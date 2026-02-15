<?php

require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerCours.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['adherent']);

        if (isset($_GET['id'])) {
            $history = ControllerCours::getCoursHistoryByUserId($payload->data->userId);
            if ($history !== false) {
                Response::json($history);
            } else {
                Response::error('Unable to fetch history', 500);
            }
        } else {
            Response::error('Course ID is required', 400);
        }
        break;
}