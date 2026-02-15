<?php
session_start();

if(!isset($_SESSION['token'])) {
    header('Location: login.html');
    exit();
}

switch($_SESSION['role']) {
    case 'adherent':
        header('Location: adherent/dashboard.php');
        break;
    case 'coach':
        header('Location: coach/dashboard.php');
        break;
    case 'admin':
        header('Location: admin/dashboard.php');
        break;
    default:
        session_destroy();
        header('Location: login.html');
        break;
}