<?php
require_once '../models/Adherent.php';
require_once '../dao/AdherentDAO.php';

class ControllerAdherents {
    public static function getAdherentById($id, $role) {
        return AdherentDAO::getAdherentById($id);
    }

    public static function getAdherentsByCoursId($cours_id, $role) {
        return AdherentDAO::getAdherentsByCoursId($cours_id);
    }


}