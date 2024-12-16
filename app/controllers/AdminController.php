<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;

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

    public function register()
    {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $role = sanitize($_POST['role']);
        $password = sanitize($_POST['password']);

        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $role = htmlspecialchars($role);
        $password = htmlspecialchars($password);

        // Validate required fields
        if (!validateRequired($name) || !validateRequired($email) || !validateRequired($role) || !validateRequired($password)) {
            $error = "All fields are required.";
            $this->view('admin/register', ['error' => $error]);
            return;
        }
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $userModel = Admin::getInstance();
        if (!empty($userModel->find('email', $email))) {
            $error = "Email already exists.";
            $this->view('admin/register', ['error' => $error]);
            return;
        }
        // Insert new user into database
        $table_columns = ['username', 'email',  'password']; //'role',
        $table_data = [$name, $email, $hashedPassword]; //'role',
        if (!empty($userModel->save($table_columns, $table_data))) {
            $success = "User registered successfully.";
            $this->view('admin/login', ['success' => $success]);
        } else {
            $error = "Failed to register user.";
            $this->view('admin/register', ['error' => $error]);
        }
    }
}
