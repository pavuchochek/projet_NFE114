<?php
switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':    
        require_once '../sql/dto/authDTO.php';
        $jwt = new JWT();
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];

        if(empty($email) || empty($password)) {
            Response::error('Email and password are required', 400);
            header('Location: login.html');
            exit();
        }
        
        $userId = AuthDTO::login($email, $password);

        if ($userId) {
            session_start();
            $_SESSION['token'] = $jwt->encode(['user_id' => $userId], $_ENV['JWT_SECRET']);
            
            Response::json(['success' => true, 'user_id' => $userId]);
            header('Location: index.php');

        } else {
            Response::error('Invalid credentials', 401);
            header('Location: login.html');
        }

        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}