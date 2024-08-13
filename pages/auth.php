<?php
class auth {
    public static function get(Engine $engine): void {
        echo $engine->getTemplate(__CLASS__);
    }

    public static function post(Engine $engine): void {
        
    }
}