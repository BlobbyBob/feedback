<?php

defined('BASEPATH') OR exit('No direct script access allowed');

spl_autoload_register(function ($class) {
    if (strpos($class, 'Models\\') !== false)
        include_once str_replace('\\', '/', __DIR__ . '/../models/orm/' . strtolower(substr($class, 7)) . '.php');
});
