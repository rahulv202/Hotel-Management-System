<?php

namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller
{
    public function index_login()
    {
        $this->view('admin/login');
    }
    public function index_register()
    {
        $this->view('admin/register');
    }
}
