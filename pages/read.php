<?php

class read {
    public static function get(Engine $engine) {
        $book = new Book($_GET['id']);
        echo $engine->getTemplate(__CLASS__, [
            "name" => $book->name,
            "id" => $book->id,
            'page' => array_key_exists('page', $_GET) ? $_GET['page'] : '',
            "header" => $engine->getPart('header')
        ]);
    }
}