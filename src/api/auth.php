<?php
require("../utils/Response.php");
switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':    
        require_once '../sql/dto/authDTO.php';
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $role = $data['role'] ?? '';

        if(empty($email) || empty($password)) {
            Response::error('Email and password are required', 400);
            exit();
        }
        
        $userId = AuthDTO::login($email, $password, $role);

        if ($userId) {
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['role'] = $role;
            
            Response::json(['success' => true, 'user_id' => $userId]);
        } else {
            Response::error('Invalid credentials', 401);
        }

        break;
    default:
        Response::error('Method not allowed', 405);
        break;
}