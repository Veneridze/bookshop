<?php

class Book extends Model {
    protected $table = 'books';

    public static function create(string $name, array $headers = []): self {
        global $engine;
        $headers = json_encode($headers, JSON_NUMERIC_CHECK);
        $class = __CLASS__;
        $engine->db->query("INSERT INTO `books` (`name`, `headers`, `user_id`) VALUES ('{$name}', '{$headers}', {$engine->user->id})");
        return new $class($engine->db->insert_id);
    }

    public function changeImage(string $tmp): void {
        move_uploaded_file($_FILES['image']['tmp_name'], "../bookimage/".$this->id);
    }

    public function update(string $name, array $headers = []): self {
        global $engine;
        $headers = json_encode($headers, JSON_NUMERIC_CHECK);
        $class = __CLASS__;
        $engine->db->query("UPDATE `books` SET `name` = '{$name}', `headers` = '{$headers}', `user_id` = {$engine->user->id}");
        return new $class($engine->db->insert_id);
    }

    public function delete() {
    
    }
}