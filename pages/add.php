<?php
class add {
    public static function get(Engine $engine) {
        echo $engine->getTemplate('add', [
            "header" => $engine->getPart('header')
        ]);
    }

    public static function post(Engine $engine) {
        $book = Book::create($_POST['name'], array_key_exists('headers', $_POST) ? $_POST['headers'] : null);
        if(array_key_exists('image', $_FILES)) {
            $book->changeImage($_FILES['image']['tmp_name']);
        }
        $engine->redirect("show", [
            'id' => $book->id
        ]);
    }
}