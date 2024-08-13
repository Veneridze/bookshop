<?php
require_once 'class/Book.php';
require_once 'class/User.php';

require_once 'pages/logout.php';
require_once 'pages/edit.php';
require_once 'pages/add.php';
require_once 'pages/auth.php';
require_once 'pages/read.php';
require_once 'pages/reg.php';
require_once 'pages/show.php';
require_once 'pages/index.php';
require_once 'pages/bookimage.php';
require_once 'pages/bookfile.php';
class Engine
{
    private stdClass $conf;
    public mysqli $db;

    public User|null $user = null;
    public function __construct()
    {
        if (!file_exists('../config.json')) {
            throw new Exception('Конфигурационный файл не обнаружен');
        }
        $this->conf = json_decode(file_get_contents('../config.json'));
        $this->db = new mysqli($this->conf->HOST, $this->conf->USERNAME, $this->conf->PASSWORD, $this->conf->DATABASE, $this->conf->PORT);
    }
    /**
     * Summary of redirect
     * @param string $path
     * @param array<string, string> $params
     * @return void
     */
    public function redirect(string $path = null, array $params = null): void {
        if($path == null) {
            if($params) {
                header("Location: /?".http_build_query($params));
            } else {
                header("Location: /");
            }
            
        } else {
            if($params) {
                header("Location: /{$path}?".http_build_query($params));
            } else {
                header("Location: /{$path}");
            }
            
        }
        
    }
    /**
     * Summary of getPages
     * @return array<string>
     */
    public function getPages(): array {
        return array_values(array_filter(array_map(fn($page) => basename($page, ".php"), scandir('../pages')), fn($page) => $page != '.' && $page != '..'));
    }

    public function getPart(string $name, array $params = null) {
        $content = file_get_contents("../parts/{$name}.html");
        return $params ? str_replace(
            array_map(fn(string $key) => "%{$key}%" ,array_keys($params)), 
            array_values($params), 
            $content) : $content;
    }
    public function resolvePage(string $page, string $method): void {
        $method = strtolower($method);
        //echo $page;
        //exit;
        if(!$this->checkAuth() && $page != 'auth' && $page != 'reg') {
            $this->redirect('auth');
            exit;
        }
        $page = $page == '' || $page == '/' ? 'index' : strtolower($page);
        if(!in_array($page, $this->getPages())) {
            http_response_code(404);
            exit;
        }

        if(!class_exists($page) || !method_exists($page, $method)) {
            http_response_code(404);
            exit;
        }

        $page::$method($this);
    }
    /**
     * Summary of getTemplate
     * @param string $name
     * @param array<string, string> $params
     * @return string
     */
    public function getTemplate(string $name, array $params = null) {
        $content = file_get_contents("../templates/{$name}.html");
        return $params ? str_replace(
            array_map(fn(string $key) => "%{$key}%" ,array_keys($params)), 
            array_values($params), 
            $content) : $content;
    }

    public function getMethod(): string {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function checkAuth(): bool
    {
        session_start();
        if(array_key_exists('user_id', $_SESSION)) {
            $this->user = new User($_SESSION['user_id']);
            return true;
        } else {
            return false;
        }
    }
}
class Model {
    protected $data = [];
    public function __get($value): mixed {
        if(!array_key_exists($value, $this->data)) {
            return null;
        }
        return $this->data[$value];
    }
    public function __construct(int $id) {
        global $engine;
        $query = $engine->db->query("SELECT * FROM `{$this->table}` WHERE `id` = {$id}");
        if(mysqli_num_rows($query) == 1) {
            $this->data = mysqli_fetch_assoc($query);
        }
    }
}

interface Page {
    public static function get(Engine $engine): false | string;

    public static function post(Engine $engine): false | string;

    public static function patch(Engine $engine): false | string;

    public static function delete(Engine $engine): false | string;

}

#init
$engine = new Engine();