<?php
require_once '../models/Adherent.php';
require_once '../dao/AdherentDAO.php';

class ControllerAdherents {
    public static function getAdherentById($id, $role, $userId): array
    {
        if ($role === 'adherent' && $id == $userId) {
           return AdherentDAO::getAdherentProfile($id)->toJson();
        }
        
        return false;
    }

    public static function getAdherentsByCoursId($cours_id, $role): bool|array
    {
        if ($role === 'coach' || $role === 'admin') {
            $adherents = AdherentDAO::getAdherentsByCoursId($cours_id);
            if ($adherents) {
                $adherentsArray = [];
                foreach ($adherents as $adherent) {
                    $adherentsArray[] = $adherent->toArrayForCours();
                }
                return $adherentsArray;
            }
        }
        return false;
    }

    public static function getAllAdherents($role): bool|array
    {
        if ($role === 'admin') {
            return AdherentDAO::getAllAdherents();
        } else {
            return false;
        }
    }

}