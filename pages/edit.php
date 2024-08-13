<?php

class edit {
    public static function get(Engine $engine): void {
        $book = new Book($_GET['id']);
        echo $engine->getTemplate(__CLASS__, [
            "header" => $engine->getPart('header'),
            "id" => $book->id,
            "name" => $book->name,
            "name_translated" => $book->name_translated,
            "headers" => $book->headers
        ]);
    }

    public static function post(Engine $engine): void {
        $book = new Book($_GET['id']);
        $book->update($_POST['name'], array_key_exists('headers', $_POST) ? $_POST['headers'] : null);
        if(array_key_exists('image', $_FILES)) {
            $book->changeImage($_FILES['image']['tmp_name']);
        }

        $engine->redirect('show', [
            'id' => $book->id
        ]);
    }
}