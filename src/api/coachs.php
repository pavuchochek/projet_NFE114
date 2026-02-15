<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerCoachs.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['coach', 'admin']);
        if(isset($_GET['id'])) {
            $coachs = ControllerCoachs::getCoachById($_GET['id'], $payload->data->role, $payload->data->userId);
            $coachs= $coachs->toArray();
        }
        else {
            $coachs = ControllerCoachs::getAllCoachs($payload->data->role);
        }
        if ($coachs !== false) {
            Response::json($coachs);
        } else {
            Response::error('Unable to fetch coachs', 500);
        }
        break;

    default:
        Response::error('Method not allowed', 405);
        break;
}