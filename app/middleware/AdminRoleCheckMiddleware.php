<?php

namespace App\Middleware;

class AdminRoleCheckMiddleware
{
    public function handle($requestUri, $next)
    {
        if ($_SESSION['role'] !== 'Admin') {
            header('Location: /dashboard');
            exit;
        }
        // Continue to the next middleware or controller action
        return $next($requestUri);
    }
}
