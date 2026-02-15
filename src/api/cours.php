<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerCours.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['adherent', 'coach', 'admin']);

        if(isset($_GET['type'])) {
            $cours = ControllerCours::getCoursByType($_GET['type'], $payload->data->role);
        }
        elseif (isset($_GET['id'])) {
            $cours = ControllerCours::getCoursById($_GET['id'], $payload->data->role);
        }
        else {
            $cours = ControllerCours::getAllCours($payload->data->role);
        }
        
        if ($cours !== false) {
            Response::json($cours);
        } else {
            Response::error('Unable to fetch courses', 500);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $payload = requireAuth(['admin']);
        $result = ControllerCours::createCours($data);
        if ($result) {
            Response::json(['success' => true], 201);
        } else {
            Response::error('Failed to create course', 500);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $payload = requireAuth(['admin']);
        $result = ControllerCours::updateCours($data);
        if ($result) {
            Response::json(['success' => true]);
        } else {
            Response::error('Failed to update course', 500);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $payload = requireAuth(['admin']);
        $result = ControllerCours::deleteCours($data);
        if ($result) {
            Response::json(['success' => true]);
        } else {
            Response::error('Failed to delete course', 500);
        }
        break;

    default:
        Response::error('Method not allowed', 405);
        break;
}