<?php

class logout {
    public static function get(Engine $engine) {
        session_destroy();
        $engine->redirect('auth');
    }
}