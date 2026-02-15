<?php
session_start();
if(!isset($_COOKIE["token"])) {
    header("Location: login.html");
    exit();
}

switch ($_SESSION["role"]) {
    case 'adherent':
        require __DIR__ . '/../views/dashboard_adherent.php';
        break;

    case 'coach':
        require __DIR__ . '/../views/dashboard_coach.php';
        break;

    case 'admin':
        require __DIR__ . '/../views/dashboard_admin.php';
        break;
}
