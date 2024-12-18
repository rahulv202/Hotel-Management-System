<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Room;
use App\Models\Reservation;

class RoomController extends Controller
{
    public function room_list()
    {
        $rooms = Room::getInstance();
        if ($_SESSION['role'] == "Guest") {
            $rooms = $rooms->getAllData("status='available'");
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

    public function guest_booked_room($id)
    {
        $room = Room::getInstance();
        $data = [
            'status' => 'booked'
        ];
        if ($room->update($data, $id)) {
            if ($_SESSION['role'] == "Guest") {
                $reservations = Reservation::getInstance();
                // $data = [
                //     'room_id' => $id,
                //     'guest_id' => $_SESSION['user_id'],
                //     // 'check_in_date' => date('Y-m-d'),
                //     // 'total_amount' => 0,
                //     'status' => 'confirmed'
                //     // 'check_out_date' => date('Y-m-d', strtotime('+1 day'))
                // ];
                $table_columns = ['room_id', 'guest_id', 'status'];
                $table_data = [$id, $_SESSION['user_id'], 'confirmed'];

                $reservations->save($table_columns, $table_data);
                $this->redirect('/room_list');
            }

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

    public function manage_room_list()
    {
        $id = $_SESSION['user_id'];
        $room = Room::getInstance();
        $reservations = Reservation::getInstance();
        // Using a prepared statement for security
        $reservations = $reservations->getAllData("guest_id = {$id} And status IN ('confirmed', 'checked_in', 'checked_out', 'canceled') AND check_out_date IS NULL");
        // print_r($reservations);
        // exit();
        // Add 'room_name' = 'demo' to each reservation
        foreach ($reservations as &$reservation) {
            $rooms = $room->getAllData("id={$reservation['room_id']}");
            $reservation['room_number'] = $rooms[0]['room_number'];
            $reservation['room_type'] = $rooms[0]['room_type'];
            $reservation['price_per_night'] = $rooms[0]['price_per_night'];
        }

        // Optional: Unset the reference to avoid potential side effects
        unset($reservation);

        $this->view('rooms/manage-room-list', ['reservations' => $reservations]);
    }

    public function check_in_room($reservation_id, $room_price)
    {
        $reservations = Reservation::getInstance();
        $data = [
            'check_in_date' => date('Y-m-d'),
            'status' => 'checked_in',
            'total_amount' => $room_price
        ];
        if ($reservations->update($data, $reservation_id)) {
            $this->redirect('/manage-room-list');
        } else {
            $error = "Something went wrong";
            $this->view('rooms/manage-room-list', ['error' => $error]);
        }
    }

    public function check_out_room($reservation_id, $room_price, $room_id)
    {
        $reservations = Reservation::getInstance();
        $data = [
            'check_out_date' => date('Y-m-d'),
            'status' => 'checked_out',
            'total_amount' => $room_price
        ];
        if ($reservations->update($data, $reservation_id)) {
            $rooms = Room::getInstance();
            $data = [
                'status' => 'available'
            ];
            if ($rooms->update($data, $room_id)) {
                $this->redirect('/manage-room-list');
            } else {
                $error = "Something went wrong";
                $this->view('rooms/manage-room-list', ['error' => $error]);
            }
        } else {
            $error = "Something went wrong";
            $this->view('rooms/manage-room-list', ['error' => $error]);
        }
    }
}
