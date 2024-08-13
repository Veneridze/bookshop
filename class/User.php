<?php

class User extends Model {
    
    protected $table = 'users';
    public static function create(string $login, string $password): self {
        global $engine;
        $class = __CLASS__;
        $engine->db->query("INSERT INTO `users` (`login`, `password`) VALUES ('$login', MD5('$password'))");
        return new $class($engine->db->insert_id);
    }
    /**
     * Summary of books
     * @return array<Book>
     */
    public function books(): array {
        global $engine;
        $result = [];
        $query = $engine->db->query("SELECT `id` FROM `books` WHERE `user_id` = {$this->id}");
        while($row = mysqli_fetch_array($query)) {
            $result[] = new Book($row['id']);
        }
        return $result;
    }

    public function delete() {
    
    }
}