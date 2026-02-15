<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerReservations.php';

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['adherent']);
        $reservations = ControllerReservations::getAllReservations($payload->data->role, $payload->data->user_id);
        if ($reservations !== false) {
            Response::json($reservations);
        } else {
            Response::error('Unable to fetch reservations', 500);
        }
        break;

    case 'POST':
        $payload = requireAuth(['adherent']);
        $data = json_decode(file_get_contents('php://input'), true);
        $result = ControllerReservations::createReservation($data, $payload->data->user_id);
        if ($result) {
            Response::json(['success' => true], 201);
        } else {
            Response::error('Failed to create reservation', 500);
        }
        break;

    case 'DELETE':
        $payload = requireAuth(['adherent']);
        $id = $_GET['id'] ?? null;
        if (!$id) {
            Response::error('Reservation ID is required', 400);
            exit();
        }
        $result = ControllerReservations::annulerReservation($id, $payload->data->user_id);
        if ($result) {
            Response::json(['success' => true]);
        } else {
            Response::error('Failed to cancel reservation', 500);
        }
        break;
        
    default:
        Response::error('Method not allowed', 405);
        break;
}