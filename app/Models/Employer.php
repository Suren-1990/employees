<?php

namespace App\Models;

use App\Base\Model;

class Employer extends Model
{
    protected $json_path = STORAGE_PATH . 'employees.json';
}
