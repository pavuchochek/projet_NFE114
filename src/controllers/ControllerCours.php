<?php
require_once '../dao/CoursDAO.php';

class ControllerCours {
    public static function getAllCours($role, $userId) {
        switch($role) {
            case 'adherent':
                return self::getAllCoursForAdherent($userId);
            case 'coach':
                return self::getAllCoursForCoach($userId);
            case 'admin':
                return self::getAllCoursForAdmin();
            default:
                return false;
        }
    }
    

    public static function getCoursById($id): ?Cours
    {
        return CoursDAO::getCoursById($id);
    }

    public static function getAllCoursForAdherent($adherentId): array
    {
        return CoursDAO::getAllCoursForAdherent($adherentId);
    }

    public static function getAllCoursForCoach($coachId): array
    {
        return CoursDAO::getAllCoursForCoach($coachId);
    }

    public static function getAllCoursForAdmin(): array{
        return CoursDAO::getAllCoursForAdmin();
    }

    public static function getCoursByType(mixed $type, $role): bool|array
    {
        if($role == 'adherent') {
            return CoursDAO::getCoursByType($type);
        }
        return false;
    }
}