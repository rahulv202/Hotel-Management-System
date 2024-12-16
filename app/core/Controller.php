<?php

namespace App\Core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        require_once APP_PATH . "views/layouts/header.php";
        require_once APP_PATH . 'views/' . $view . '.php';
        require_once APP_PATH . "views/layouts/footer.php";
    }

    protected function redirect($url)
    {
        header("Location: $url"); //redirect
        exit();
    }
}
