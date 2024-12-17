<?php

namespace App\Middleware;

class GuestRoleCheckMiddleware
{
    public function handle($requestUri, $next)
    {
        if ($_SESSION['role'] !== 'Guest') {
            header('Location: /dashboard');
            exit;
        }
        // Continue to the next middleware or controller action
        return $next($requestUri);
    }
}
