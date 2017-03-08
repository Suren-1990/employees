<?php

include_once(APP_PATH . 'Base/Request.php');
include_once(APP_PATH . 'Base/Model.php');
include_once(APP_PATH . 'Models/Employer.php');
include_once(APP_PATH . 'Helpers.php');
include_once(APP_PATH . 'Base/Validation/Validator.php');
include_once(DIRECTORY_ROOT . 'routes/web.php');

class Bootstrap
{
    public function run()
    {
        $uri = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        echo Route::get($uri);
    }
}
