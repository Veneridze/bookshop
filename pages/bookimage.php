<?php

class bookimage {
    public static function get(Engine $engine) {
        $path = "../".__CLASS__."/".$_GET['id'];
        if(file_exists($path)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: Binary");
            readfile($path);
            die();
        } else {
            http_response_code(404);
        }
    }
}