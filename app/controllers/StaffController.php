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

    public function login()
    {
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        // Validate required fields
        if (!validateRequired($email) || !validateRequired($password)) {
            $error = "All fields are required.";
            $this->view('staff/login', ['error' => $error]);
            return;
        }
        // Check if email exists
        $userModel = Staff::getInstance();
        $user = $userModel->find('email', $email);
        if (empty($user)) {
            $error = "Email or password is incorrect.";
            $this->view('staff/login', ['error' => $error]);
            return;
        }
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['is_login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = (isset($user['name'])) ? $user['name'] : $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = "Staff"; //$user['role'];
            // Redirect to dashboard
            $this->redirect('/dashboard');
        } else {
            $error = "Email or password is incorrect.";
            $this->view('staff/login', ['error' => $error]);
        }
    }

    public function logout()
    {
        // Unset all session variables
        session_unset();
        // Destroy the session
        session_destroy();
        // Redirect to login page
        $this->redirect('/staff/login');
    }
}
