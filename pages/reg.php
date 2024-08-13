<?php
class reg {
    public static function get(Engine $engine): void {
        echo $engine->getTemplate(__CLASS__, [
            'errordublicate' => array_key_exists('dublicate', $_GET) ? '<span class="text-danger">Такой адрес электронной почты уже занят</span>' : ''
        ]);
    }

    public static function post(Engine $engine): void {
        //Проверка что такая почта не занята
        if(mysqli_num_rows($engine->db->query("SELECT NULL FROM `users` WHERE `login` = '".$_POST['login']."'")) > 0) {
            $engine->redirect('reg', [
                'dublicate' => 1
            ]);
        }
        $user  = User::create($_POST['login'], $_POST['password']);
        session_start();
        $_SESSION['user_id'] = $user->id;
        $engine->redirect();
    }
}