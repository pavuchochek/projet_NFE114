<?php
require_once 'JWT.php';
require_once 'Response.php';

function requireAuth(array $allowedRoles = []) {
    if (!isset($_COOKIE['token'])) {
        Response::error("Token d'authentification manquant", 401);
        exit;
    }

    $token = $_COOKIE['token'];

    try {
        $payload = JWTService::verify($token);
    } catch (Exception $e) {
       Response::error($e->getMessage(), $e->getCode());
       exit;
    }

    return $payload;
}
