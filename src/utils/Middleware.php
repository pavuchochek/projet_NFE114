<?php
require_once __DIR__ . '/JWT.php';

function requireAuth(array $allowedRoles = []) {
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        Response::error('Authorization header missing', 401);
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $payload = JWTService::verify($token);

    if (!$payload) {
        Response::error('Invalid token', 401);
        exit();
    }

    if ($allowedRoles && !in_array($payload->data->role, $allowedRoles)) {
        Response::error('Forbidden', 403);
        exit('Forbidden');
    }

    return $payload;
}
