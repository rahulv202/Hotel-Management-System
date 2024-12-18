<?php

namespace App\Models;

use App\Core\Model;

class API_tokens extends Model
{
    protected $table = 'api_tokens';
    private static $instance_obj;
    public static function getInstance()
    {
        if (!self::$instance_obj) {
            self::$instance_obj = new self();
        }
        return self::$instance_obj;
    }
}
