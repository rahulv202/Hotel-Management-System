<?php

namespace App\Core;

class Database
{
    private static $instance;
    private $connection;
    private function __construct()
    {
        $this->connection = new \PDO('mysql:host=DB_HOST;dbname=DB_NAME', 'DB_USER', 'DB_PASS');
    }
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
