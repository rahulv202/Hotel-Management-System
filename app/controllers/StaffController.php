<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index_login()
    {
        $this->view('staff/login');
    }
    public function index_register()
    {
        $this->view('staff/register');
    }

    public function register()
    {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $role = sanitize($_POST['role']);
        $password = sanitize($_POST['password']);
        $phone = sanitize($_POST['phone']);

        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $role = htmlspecialchars($role);
        $password = htmlspecialchars($password);
        $phone = htmlspecialchars($phone);


        // Validate required fields
        if (!validateRequired($name) || !validateRequired($email) || !validateRequired($password) || !validateRequired($phone) || !validateRequired($role)) {
            $error = "All fields are required.";
            $this->view('staff/register', ['error' => $error]);
            return;
        }
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $userModel = Staff::getInstance();
        if (!empty($userModel->find('email', $email))) {
            $error = "Email already exists.";
            $this->view('staff/register', ['error' => $error]);
            return;
        }
        // Insert new user into database
        $table_columns = ['name', 'email',  'password', 'phone', 'role']; //'role',
        $table_data = [$name, $email, $hashedPassword, $phone, $role]; //'role',
        if (!empty($userModel->save($table_columns, $table_data))) {
            $success = "User registered successfully.";
            $this->view('staff/login', ['success' => $success]);
        } else {
            $error = "Failed to register user.";
            $this->view('staff/register', ['error' => $error]);
        }
    }
}
