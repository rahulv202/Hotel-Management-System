<?php

namespace App\Middleware;

class StaffRoleCheckMiddleware
{
    public function handle($requestUri, $next)
    {
        if ($_SESSION['role'] !== 'Staff') {
            header('Location: /dashboard');
            exit;
        }
        // Continue to the next middleware or controller action
        return $next($requestUri);
    }
}
