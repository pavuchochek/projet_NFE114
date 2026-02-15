<?php
setcookie('token', '', [
    'expires' => time() - 3600, // date passée pour supprimer
    'path' => '/',
    'httponly' => true,
    'secure' => true,   // si HTTPS
    'samesite' => 'Lax'
]);

// Optionnel : détruire la session
session_start();
session_destroy();

echo json_encode(['success' => true, 'message' => 'Déconnecté']);