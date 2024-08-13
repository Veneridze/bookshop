<?php

class show {
    public static function get(Engine $engine) {
        $book = new Book($_GET['id']);
        $headers = "";
        foreach (json_decode($book->headers, JSON_NUMERIC_CHECK) as $header) {
            $headers.= $engine->getPart('bookheader', [
                "id" => $book->id,
                "page" => $header['page'],
                "name" => $header['name']
            ]);
        }
        echo $engine->getTemplate(__CLASS__, [
            "id" => $book->id,
            "name" => $book->name,
            "name_translated" => $book->name_translated,
            "header" => $engine->getPart('header'),
            "headers" => $headers
        ]);
    }
}