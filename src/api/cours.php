<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerCours.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['adherent', 'coach', 'admin']);

        if(isset($_GET['type_id'])) {
            $cours = ControllerCours::getCoursByType($_GET['type_id'], $payload->data->role, $payload->data->userId);
        }
        elseif (isset($_GET['id'])) {
            $cours = ControllerCours::getCoursById($_GET['id']);
        }
        else {
            $cours = ControllerCours::getAllCours($payload->data->role, $payload->data->userId);
        }
        
        if ($cours !== false) {
            Response::json($cours);
        } else {
            Response::error('Unable to fetch courses', 500);
        }
        break;

    default:
        Response::error('Method not allowed', 405);
        break;
}