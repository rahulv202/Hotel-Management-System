<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\API_tokens;
use App\Utils\JWTUtil;
use App\Models\Room;

header("Content-Type: application/json");

class APIController
{
    private $jwtUtil;
    public function __construct()
    {

        $this->jwtUtil = new JWTUtil(); //$jwtConfig['jwt']
    }

    public  function api_key()
    {
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        // Validate required fields
        if (!validateRequired($email) || !validateRequired($password)) {
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }
        // Check if email exists
        $userModel = Admin::getInstance();
        $user = $userModel->find('email', $email);
        if (empty($user)) {

            echo json_encode(['error' => 'Email is incorrect.']);
            return;
        }
        // Verify password
        if (password_verify($password, $user['password'])) {
            $api_tokens = API_tokens::getInstance();
            $user_api = $api_tokens->getAllData("user_id={$user['id']}");
            if (!empty($user_api) && !empty($user_api[0]['token']) && $user_api[0]['expires_at'] == null) {
                echo json_encode(['token' => $user_api[0]['token'], 'message' => 'You already have an API key.']);
                return;
            }
            // Generate API key
            $token = $this->jwtUtil->generateToken(['id' => $user['id'], 'role' => "Admin"]);
            $api_tokens->save(['token', 'user_id'], [$token, $user['id']]); //, 'expires_at' //null
            echo json_encode(['token' => $token, 'message' => 'API Token Create successful']);
        } else {
            echo json_encode(['error' => 'password is incorrect.']);
            return;
        }
    }

    public function list_room()
    {
        $rooms = Room::getInstance();

        $rooms = $rooms->getAllData();

        echo json_encode(['rooms_data' => $rooms]);
    }

    public function add_room()
    {
        $room_no = sanitize($_POST['room_no']);
        $room_type = sanitize($_POST['room_type']);
        $room_price = sanitize($_POST['room_price']);
        $room_no = htmlspecialchars($room_no);
        $room_type = htmlspecialchars($room_type);
        $room_price = htmlspecialchars($room_price);
        // Validate required fields
        if (!validateRequired($room_no) || !validateRequired($room_type) || !validateRequired($room_price)) {
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }
        // Insert new room into
        $table_columns = ['room_number', 'room_type', 'price_per_night'];
        $table_data = [$room_no, $room_type, $room_price];
        $roomModel = Room::getInstance();
        if (!empty($roomModel->save($table_columns, $table_data))) {
            echo json_encode(['message' => 'Room added successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to add room.']);
            return;
        }
    }
    public function update_room($id)
    {
        $room_no = sanitize($_POST['room_no']);
        $room_type = sanitize($_POST['room_type']);
        $room_price = sanitize($_POST['room_price']);
        $room_no = htmlspecialchars($room_no);
        $room_type = htmlspecialchars($room_type);
        $room_price = htmlspecialchars($room_price);

        // Validate required fields
        if (!validateRequired($room_no) || !validateRequired($room_type) || !validateRequired($room_price)) {
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }
        // Insert new room into database
        $room = Room::getInstance();
        if ($room->update(['room_number' => $room_no, 'room_type' => $room_type, 'price_per_night' => $room_price], $id)) {
            echo json_encode(['message' => 'Room updated successfully.']);
            return;
        } else {
            echo json_encode(['error' => 'Failed to update room.']);
            return;
        }
    }

    public function delete_room($id)
    {
        $room = Room::getInstance();
        if ($room->delete($id)) {
            echo json_encode(['message' => 'Room deleted successfully.']);
            return;
        } else {
            echo json_encode(['error' => 'Failed to delete room.']);
            return;
        }
    }

    public function api_key_delete()
    {
        $api_tokens = API_tokens::getInstance();
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = substr($authHeader, 7);
        $decoded = $this->jwtUtil->verify($token, null);
        $api_data = $api_tokens->getAllData("user_id={$decoded->id} AND token IS NOT NULL ORDER BY id DESC LIMIT 1");
        $update_data = ['expires_at' => date("Y-m-d H:i:s",)];
        if ($api_tokens->update($update_data, $api_data[0]['id'])) {
            echo json_encode(['message' => 'API key deleted successfully.']);
            return;
        } else {
            echo json_encode(['error' => 'Failed to delete API key.']);
            return;
        }
    }
}
