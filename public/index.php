<?php
require_once '../engine.php';

$engine->resolvePage(basename(str_contains($_SERVER['REQUEST_URI'], '?') ? strstr($_SERVER['REQUEST_URI'], '?', true) : $_SERVER['REQUEST_URI']), $_SERVER['REQUEST_METHOD']);