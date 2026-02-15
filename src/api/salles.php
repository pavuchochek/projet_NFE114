<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerSalles.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['admin']);
        if(isset($_GET['id'])) {
            $salles = ControllerSalles::getSalleById($_GET['id']);
        }
        else {
            $salles = ControllerSalles::getAllSalles();
        }
        if ($salles !== false) {
            Response::json($salles);
        } else {
            Response::error('Unable to fetch salles', 500);
        }
        break;

    default:
        Response::error('Method not allowed', 405);
        break;
}