<?php

namespace App\Base;

class Request
{
    private $data = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {
        if (isset($_POST) && count($_POST) > 0) {
            $this->data = filter_var_array($_POST, FILTER_SANITIZE_STRING);
        }
        if (isset($_GET) && count($_GET) > 0) {
            $this->data = array_merge($this->data, filter_var_array($_GET, FILTER_SANITIZE_STRING));
        }
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if (key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return $default;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}
