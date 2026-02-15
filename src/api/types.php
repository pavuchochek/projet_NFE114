<?php
require_once '../utils/Middleware.php';
require_once '../utils/Response.php';


switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $payload = requireAuth(['adherent', 'coach', 'admin']);
        $config_json=file_get_contents('../config.json');
        Response::json(json_decode($config_json, true));
        break;

    default:
        Response::error('Method not allowed', 405);
        break;
}