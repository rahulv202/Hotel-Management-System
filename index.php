<?php
define("APP_PATH", __DIR__ . '/app/');
require_once APP_PATH . 'config/config.php';
require_once __DIR__ . '/libs/helpers.php';
require_once 'vendor/autoload.php';
session_start();

use App\Core\Route;
use App\Middleware\LoginCheckMiddleware;


$router = new Route();
// Define your routes here
//Admin User
$router->get('/admin/register', 'AdminController@index_register', []);
$router->get('/admin/login', 'AdminController@index_login', []);
$router->post('/admin/register', 'AdminController@register', [LoginCheckMiddleware::class]);
$router->post('/admin/login', 'AdminController@login', [LoginCheckMiddleware::class]);
// Guest user
$router->get('/guest/register', 'GuestController@index_register', []);
$router->get('/guest/login', 'GuestController@index_login', []);
$router->post('/guest/register', 'GuestController@register', [LoginCheckMiddleware::class]);
$router->post('/guest/login', 'GuestController@login', [LoginCheckMiddleware::class]);
// Staff user
$router->get('/staff/register', 'StaffController@index_register', []);
$router->get('/staff/login', 'StaffController@index_login', []);
$router->post('/staff/register', 'StaffController@register', [LoginCheckMiddleware::class]);
$router->post('/staff/login', 'StaffController@login', [LoginCheckMiddleware::class]);

try {
    // Resolve the route
    $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
