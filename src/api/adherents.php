<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once "../controllers/ControllerAdherents.php";

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['adherent', 'coach', 'admin']);
        if(isset($_GET['id'])) {
            $adherents = ControllerAdherents::getAdherentById($_GET['id'], $payload->data->role);
        }
        elseif (isset($_GET["cours_id"])) {
            $adherents = ControllerAdherents::getAdherentsByCoursId($_GET['cours_id'], $payload->data->role);
        }
        else {
            $adherents = ControllerAdherents::getAllAdherents($payload->data->role);
        }
        if ($adherents !== false) {
            Response::json($adherents);
        } else {
            Response::error('Unable to fetch adherents', 500);
        }
        break;

    default:
        Response::error('Method not allowed', 405);
        break;
}