<?php

define('DIRECTORY_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

define('STORAGE_PATH', DIRECTORY_ROOT . 'storage' . DIRECTORY_SEPARATOR);

define('APP_PATH', DIRECTORY_ROOT . '/app/');

define('VIEWS_PATH', DIRECTORY_ROOT . '/resources/views/');

define('CONTROLLERS_PATH', DIRECTORY_ROOT . '/app/Http/Controllers/');

include_once(APP_PATH . 'Base/Bootstrap.php');

$how = new Bootstrap();

$how->run();
