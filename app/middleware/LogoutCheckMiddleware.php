<?php

namespace App\Middleware;

class LogoutCheckMiddleware
{
    public function handle($requestUri, $next)
    {
        // echo isset($_SESSION['is_login']) . "<br>";
        // echo $_SESSION['is_login'];
        if (!isset($_SESSION['is_login'])) {
            // Redirect to the login page
            header('Location: /guest/login');
            exit;
        }
        // Continue to the next middleware or controller action
        return $next($requestUri);
    }
}
