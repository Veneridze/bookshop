<?php
class index {
    public static function get(Engine $engine): void {
        $books_html = '';
        foreach ($engine->user->books() as $book) {
            $books_html .= $engine->getPart('bookcard', [
                "id" => $book->id,
                "name" => $book->name,
                "name_translated" => $book->name_translated
            ]);
        }
        echo $engine->getTemplate(__CLASS__, [
            'books' => $books_html,
            'books_count' => count($engine->user->books()),
            "header" => $engine->getPart('header')
        ]);
    }

    /*public static function post(Engine $engine): void {
        $user  = User::create($_POST['login'], $_POST['password']);
        session_start();
        $_SESSION['user_id'] = $user->id;
        $engine->redirect();
    } */
}