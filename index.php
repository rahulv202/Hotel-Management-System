<?php
define("APP_PATH", __DIR__ . '/app/');
require_once APP_PATH . 'config/config.php';
require_once __DIR__ . '/libs/helpers.php';
require_once 'vendor/autoload.php';
session_start();

use App\Core\Route;
use App\Middleware\LoginCheckMiddleware;
use App\Middleware\LogoutCheckMiddleware;
use App\Middleware\AdminRoleCheckMiddleware;
use App\Middleware\StaffRoleCheckMiddleware;
use App\Middleware\GuestRoleCheckMiddleware;
use App\Middleware\APIMiddleware;


$router = new Route();
// Define your routes here
//Admin User
$router->get('/admin/register', 'AdminController@index_register', []);
$router->get('/admin/login', 'AdminController@index_login', []);
$router->post('/admin/register', 'AdminController@register', [LoginCheckMiddleware::class]);
$router->post('/admin/login', 'AdminController@login', [LoginCheckMiddleware::class]);
$router->get('/admin/logout', 'AdminController@logout', [LogoutCheckMiddleware::class]);
$router->get('/addroom', 'RoomController@addroom', [LogoutCheckMiddleware::class, AdminRoleCheckMiddleware::class]);
$router->post('/addroom', 'RoomController@save_addroom', [LogoutCheckMiddleware::class, AdminRoleCheckMiddleware::class]);
$router->get('/edit-room/{param}', 'RoomController@edit_room', [LogoutCheckMiddleware::class, AdminRoleCheckMiddleware::class]);
$router->post('/updateroom', 'RoomController@update_room', [LogoutCheckMiddleware::class, AdminRoleCheckMiddleware::class]);
$router->get('/delete-room/{param}', 'RoomController@delete_room', [LogoutCheckMiddleware::class, AdminRoleCheckMiddleware::class]);
// Guest user
$router->get('/guest/register', 'GuestController@index_register', []);
$router->get('/guest/login', 'GuestController@index_login', []);
$router->post('/guest/register', 'GuestController@register', [LoginCheckMiddleware::class]);
$router->post('/guest/login', 'GuestController@login', [LoginCheckMiddleware::class]);
$router->get('/guest/logout', 'GuestController@logout', [LogoutCheckMiddleware::class]);
$router->get('/guest-booked-room/{param}', 'RoomController@guest_booked_room', [LogoutCheckMiddleware::class, GuestRoleCheckMiddleware::class]);
$router->get('/manage-room-list', 'RoomController@manage_room_list', [LogoutCheckMiddleware::class, GuestRoleCheckMiddleware::class]);
$router->get('/check-in-room/{reservation_id}/{room_price}', 'RoomController@check_in_room', [LogoutCheckMiddleware::class, GuestRoleCheckMiddleware::class]);
$router->get('/check-out-room/{reservation_id}/{room_price}/{room_id}', 'RoomController@check_out_room', [LogoutCheckMiddleware::class, GuestRoleCheckMiddleware::class]);
// Staff user
$router->get('/staff/register', 'StaffController@index_register', []);
$router->get('/staff/login', 'StaffController@index_login', []);
$router->post('/staff/register', 'StaffController@register', [LoginCheckMiddleware::class]);
$router->post('/staff/login', 'StaffController@login', [LoginCheckMiddleware::class]);
$router->get('/staff/logout', 'StaffController@logout', [LogoutCheckMiddleware::class]);
$router->get('/available-room/{param}', 'RoomController@available_room', [LogoutCheckMiddleware::class, StaffRoleCheckMiddleware::class]);
$router->get('/booked-room/{param}', 'RoomController@booked_room', [LogoutCheckMiddleware::class, StaffRoleCheckMiddleware::class]);
$router->get('/maintenance-room/{param}', 'RoomController@maintenance_room', [LogoutCheckMiddleware::class, StaffRoleCheckMiddleware::class]);


$router->get('/dashboard', 'HomeController@dashboard', [LogoutCheckMiddleware::class]);
$router->get('/room_list', 'RoomController@room_list', [LogoutCheckMiddleware::class]);

// API routes Endpoints
$router->post('/api/api_key', 'APIController@api_key', []);
$router->post('/api/add_room', 'APIController@add_room', [APIMiddleware::class]);
$router->post('/api/update_room/{param}', 'APIController@update_room', [APIMiddleware::class]);
$router->get('/api/delete_room/{param}', 'APIController@delete_room', [APIMiddleware::class]);
$router->get('/api/list_room', 'APIController@list_room', [APIMiddleware::class]);
$router->post('/api/api_key_delete', 'APIController@api_key_delete', [APIMiddleware::class]);

try {
    // Resolve the route
    $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
