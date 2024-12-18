Here's a **`README.md`** file for your **Hotel Management System** project that covers setup, features, API endpoints, and usage instructions.

---

# **Hotel Management System**

## **Project Overview**

The **Hotel Management System** is a web-based application built using **PHP** with **MVC architecture** and **OOP principles**. It helps manage hotel operations such as handling reservations, rooms, guests, invoices, and user roles (admin and staff). The system also provides an **API** for secure management of rooms using JWT-based authentication.

---

## **Technologies Used**

- **PHP** (with Object-Oriented Programming)
- **MySQL** (Database)
- **MVC** (Model-View-Controller) Structure
- **Composer** (Dependency Management)
- **Firebase PHP-JWT** (JWT Library)
- **Apache** (Web Server)

---

## **Project Structure**

```
HotelManagementSystem/
│
├── index.php
|
├── composer.json
│
├── config/
│   └── config.php
│
├── core/
│   ├── App.php
│   ├── Controller.php
│   └── Database.php
│
├── controllers/
│   ├── HomeController.php
│   ├── RoomController.php
│   ├── HomeController.php
│   ├── GuestController.php
│   ├── InvoiceController.php
│   ├── AdminController.php
│   ├── StaffController.php
│   └── APIController.php
│
├── models/
│   ├── Room.php
│   ├── API_tokens.php
│   ├── Guest.php
│   ├── Invoice.php
│   ├── Admin.php
│   └── Staff.php
│
├── views/
│   ├── layouts/
│   │   ├── header.php
│   │   └── footer.php
│   │
│   ├── home/
│   ├── rooms/
│   ├── reservations/
│   ├── guests/
│   ├── invoices/
│   ├── admin/
│   └── staff/
│
|
│ 
│   
│   
│
└── libs/
    └── helpers.php
```

---

## **Setup Instructions**

### **1. Prerequisites**

- **PHP 7.4+**
- **MySQL**
- **Composer** (Dependency Manager)
- **Postman (for API testing)**


### **2. Clone the Repository**

```bash
git clone https://github.com/your-username/HotelManagementSystem.git
cd HotelManagementSystem
```

### **3. Install Dependencies**

Install the JWT library using Composer:

```bash
composer install
composer init
composer dump-autoload
composer require firebase/php-jwt
```

### **4. Database Setup**

1. Create a database named `hotel_management`.
2. Import the provided SQL File Name : hotel_management.sql


## **Features**

### **Admin Features**

- **Dashboard**: View personal information.
- **Room Management**: Add, edit, delete, and list rooms.
- **Reservation Management**: Handle reservations.
- **API Key Management**: Generate, view, and delete API keys for secure API access.

### **Staff Features**

- **Dashboard**: View personal information.
- **Manage Reservations**: Create and update reservations.

### **Guest Features**

- **View Profile**: Manage personal information.
- **View Reservations**: Check reservation details.

---

## **API Endpoints**

### **Base URL**

```
http://localhost/api/
```

### **Authentication**

All API endpoints require a valid JWT in the `Authorization` header.

```
Authorization: Bearer <your_api_key>
```

### **Endpoints**

1. **Generate API Key** (Admin Only)

   ```bash
   POST /api/api_key
   ```

   **Response:**

   ```json
   {
       "api_key": "your_jwt_token"
   }
   ```

2. **Add Room**

   ```bash
   POST /api/rooms
   ```

   **Payload:**

   ```json
   {
       "room_number": "101",
       "room_type": "Deluxe",
       "price": "100.00"
   }
   ```

3. **List Rooms**

   ```bash
   GET /api/rooms
   ```

4. **Edit Room**

   ```bash
   PUT /api/rooms/{id}
   ```

   **Payload:**

   ```json
   {
       "room_number": "102",
       "room_type": "Suite",
       "price": "150.00"
   }
   ```

5. **Delete Room**

   ```bash
   DELETE /api/rooms/{id}
   ```

6. **List API Keys**

   ```bash
   GET /api/api_key
   ```

7. **Delete API Key**

   ```bash
   DELETE /api/api_key/{id}
   ```

---

## **Security**

- **JWT Authentication** for secure API access.
- **Sanitization** of input using `htmlspecialchars()` and validation checks.
- **API Tokens** expire after 7 days by default.

---


## **License**

This project is licensed under the **MIT License**.

---

