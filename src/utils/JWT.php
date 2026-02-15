<?php
require "../vendor/autoload.php";
use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
class JWTService {
    public static function generateToken($userId, $role) {
        $payload = [
            'iss' => 'fitbooking.tigropoil.fr',
            'aud' => 'fitbooking.tigropoil.fr',
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + (60 * 60),
            'data' => [
                'userId' => $userId,
                'role' => $role
            ]
        ];

        return FirebaseJWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
    }

    public static function validateToken($token) {
        try {
            $decoded = FirebaseJWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
}