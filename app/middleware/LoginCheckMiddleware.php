<?php

namespace App\Middleware;

class LoginCheckMiddleware
{
    public function handle($requestUri, $next)
    {
        if (!isset($_SESSION['is_login'])) {
            // Redirect to the login page
            header('Location: /guests/login');
            exit;
        }
        // Continue to the next middleware or controller action
        return $next($requestUri);
    }
}
