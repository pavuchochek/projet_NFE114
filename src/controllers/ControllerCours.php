<?php
require_once '../dao/CoursDAO.php';

class ControllerCours {
    public static function getAllCours($role, $userId) {
        switch($role) {
            case 'adherent':
                $cours = self::getAllCoursForAdherent($userId);
                break;
            case 'coach':
                $cours = self::getAllCoursForCoach($userId);
                break;
            case 'admin':
                $cours = self::getAllCoursForAdmin();
                break;
            default:
                $cours = false;
                break;
        }
        if($cours !== false) {
           $coursjson = [];
           if (is_array($cours)) {
              foreach($cours as $c) {
                  $coursjson[] = $c->toArray();
              }
              } else {
                  $coursjson = $cours->toArray();
              }
        }
        return $coursjson;
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

    public static function getCoursHistoryByUserId($userId)
    {
        $cours = CoursDAO::getCoursHistoryByUserId($userId);
        if($cours !== false) {
            $coursjson = [];
            if (is_array($cours)) {
                foreach($cours as $c) {
                    $statut = ReservationDAO::getReservationStatutByCoursIdByUserId($c->getIdCours(), $userId);
                    $courseArray = $c->toArray();
                    $courseArray['statut'] = $statut;
                    $coursjson[] = $courseArray;
                }
            } else {
                $coursjson = $cours->toArray();
                $statut = ReservationDAO::getReservationStatutByCoursIdByUserId($coursjson->getIdCours(), $userId);
                $coursjson['statut'] = $statut;
            }
        }
        return $coursjson;
    }
}