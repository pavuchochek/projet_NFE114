<?php
require_once '../dao/CoursDAO.php';

class ControllerCours {
    public static function getAllCours($role) {
        switch($role) {
            case 'adherent':
                return self::getAllCoursForAdherent();
            case 'coach':
                return self::getAllCoursForCoach();
            case 'admin':
                return self::getAllCoursForAdmin();
            default:
                return false;
        }
    }
    

    public static function getCoursById($id, $role) {
        return CoursDAO::getCoursById($id);
    }

    public static function getAllCoursForAdherent() {
        return CoursDAO::getAllCoursForAdherent();
    }

    public static function getAllCoursForCoach() {
        return CoursDAO::getAllCoursForCoach();
    }

    public static function getAllCoursForAdmin() {
        return CoursDAO::getAllCoursForAdmin();
    }
}