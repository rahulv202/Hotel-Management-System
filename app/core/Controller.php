<?php

namespace App\Core;

class Controller
{
    public function views($view, $data = [])
    {
        extract($data);
        require_once APP_PATH . "/app/views/header.php";
        require_once APP_PATH . 'views/' . $view . '.php';
        require_once APP_PATH . "/app/views/footer.php";
    }

    protected function redirect($url)
    {
        header("Location: $url"); //redirect
        exit();
    }
}