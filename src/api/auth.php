<?php
require "../vendor/autoload.php";
require("../utils/Response.php");
require("../utils/JWT.php");
switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':    
        require_once '../dao/AuthDAO.php';
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $role = $data['role'] ?? '';

        if(empty($email) || empty($password)) {
            Response::error('Email and password are required', 400);
            exit();
        }
        
        $userId = AuthDAO::login($email, $password, $role);

        if ($userId) {
            $token = JWTService::generateToken($userId, $role);

            session_start();
            $_SESSION["role"] = $role;

            setcookie(
                "token",          // nom du cookie
                $token,           // valeur
                [
                    'expires' => time() + 3600,  // 1 heure
                    'path' => '/',               // accessible sur tout le site
                    'secure' => true,            // uniquement HTTPS
                    'httponly' => true,          // inaccessible via JS
                    'samesite' => 'Lax'          // protection CSRF basique
                ]
            );
            setcookie('user_id', $userId, [
                'expires' => time()+3600,
                'path' => '/',
                'secure' => true,
                'httponly' => false,
                'samesite' => 'Lax'
            ]);


            Response::json([
                'success' => true,
                'user_id' => $userId,
                'token' => $token
            ]);
        } else {
            Response::error('Invalid credentials', 401);
        }

        break;
    default:
        Response::error('Method not allowed', 405);
        break;
}