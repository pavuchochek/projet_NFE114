<?php

require_once '../utils/Middleware.php';
require_once '../utils/Response.php';
require_once '../controllers/ControllerPaiementCoach.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['admin']);
        $paiements = ControllerPaiementCoach::getPaiements();
        if (empty($paiements)) {
            Response::json([]);
        } else {
            Response::json($paiements);
        }
        break;
}