<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        // Dynamically build the class name based on the session variable
        $roleClass = 'App\\Models\\' . $_SESSION['role'];

        $obj = $roleClass::getInstance();
        $user_data = $obj->getAllData('id=' . $_SESSION['user_id']);
        $this->view('dashboard', ['user_data' => $user_data]);
    }
}
