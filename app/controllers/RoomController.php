<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    public function room_list()
    {
        $rooms = Room::getInstance();
        if ($_SESSION['role'] == "Guest") {
            $rooms = $rooms->getAllData('status=available');
        } else {
            $rooms = $rooms->getAllData();
        }
        $this->view('rooms/list', ['rooms' => $rooms]);
    }

    public function addroom()
    {
        $this->view('rooms/addroom');
    }

    public function save_addroom()
    {
        $room_no = sanitize($_POST['room_no']);
        $room_type = sanitize($_POST['room_type']);
        $room_price = sanitize($_POST['room_price']);
        $room_no = htmlspecialchars($room_no);
        $room_type = htmlspecialchars($room_type);
        $room_price = htmlspecialchars($room_price);
        // Validate required fields
        if (!validateRequired($room_no) || !validateRequired($room_type) || !validateRequired($room_price)) {
            $error = "All fields are required.";
            $this->view('rooms/addroom', ['error' => $error]);
            return;
        }
        // Insert new room into database
        $table_columns = ['room_number', 'room_type', 'price_per_night'];
        $table_data = [$room_no, $room_type, $room_price];
        $roomModel = Room::getInstance();
        if (!empty($roomModel->save($table_columns, $table_data))) {
            //$success = "Room added successfully.";
            //$this->view('rooms/list', ['success' => $success]);
            $this->redirect('/room_list');
        } else {
            $error = "Failed to add room.";
            $this->view('rooms/addroom', ['error' => $error]);
        }
    }

    public function edit_room($id)
    {
        $room = Room::getInstance();
        $room = $room->find('id', $id);
        $this->view('rooms/edit-room', ['room' => $room]);
    }

    public function update_room()
    {
        $room_no = sanitize($_POST['room_no']);
        $room_type = sanitize($_POST['room_type']);
        $room_price = sanitize($_POST['room_price']);
        $id = sanitize($_POST['id']);
        $room_no = htmlspecialchars($room_no);
        $room_type = htmlspecialchars($room_type);
        $room_price = htmlspecialchars($room_price);
        $id = htmlspecialchars($id);

        // Validate required fields
        if (!validateRequired($room_no) || !validateRequired($room_type) || !validateRequired($room_price)) {
            $error = "All fields are required.";
            $this->view('rooms/addroom', ['error' => $error]);
            return;
        }
        $room = Room::getInstance();
        $data = [
            'room_number' => $room_no,
            'room_type' => $room_type,
            'price_per_night' => $room_price
        ];
        if ($room->update($data, $id)) {
            $this->redirect('/room_list');
        } else {
            $error = "Something went wrong";
            $this->view('rooms/edit-room', ['error' => $error]);
        }
    }

    public function delete_room($id)
    {
        $room = Room::getInstance();
        if ($room->delete($id)) {
            $this->redirect('/room_list');
        } else {
            $error = "Something went wrong";
            $this->view('rooms/list', ['error' => $error]);
        }
    }

    public function available_room($id)
    {
        $room = Room::getInstance();
        $data = [
            'status' => 'available'
        ];
        if ($room->update($data, $id)) {
            $this->redirect('/room_list');
        } else {
            $error = "Something went wrong";
            $this->view('rooms/list', ['error' => $error]);
        }
    }
    public function booked_room($id)
    {
        $room = Room::getInstance();
        $data = [
            'status' => 'booked'
        ];
        if ($room->update($data, $id)) {
            $this->redirect('/room_list');
        } else {
            $error = "Something went wrong";
            $this->view('rooms/list', ['error' => $error]);
        }
    }

    public function maintenance_room($id)
    {
        $room = Room::getInstance();
        $data = [
            'status' => 'maintenance'
        ];
        if ($room->update($data, $id)) {
            $this->redirect('/room_list');
        } else {
            $error = "Something went wrong";
            $this->view('rooms/list', ['error' => $error]);
        }
    }
}
