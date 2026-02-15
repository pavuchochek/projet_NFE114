<?php
require_once '../dao/ReservationDAO.php';

class ControllerReservations {
    public static function getAllReservations($userId): array
    {
        $reservations = ReservationDAO::getAllReservations($userId);
        if($reservations) {
            $reservationsJson = [];
            foreach($reservations as $r) {
                $reservationsJson[] = $r->toArray();
            }
            return $reservationsJson;
        }
        return [];
    }

    public static function getReservationById($id, $userId) {
       return ReservationDAO::getReservationById($id, $userId);
    }

    public static function createReservation($cours_id, $adherent_id) {
        // D'abord on check si il y a assez de place dans le cours
        $nbPlaces = CoursDAO::getNbPlaces($cours_id);
        if($nbPlaces) {
            if($nbPlaces <= 0) {
                return ['error' => 'Le cours est complet.'];
            }
        }
        return ReservationDAO::createReservation($adherent_id, $cours_id);
    }

    public static function annulerReservation($coursId, $userId) {
       return ReservationDAO::annulerReservation($coursId, $userId);
    }

    public static function confirmerReservation(mixed $id, $user_id)
    {
        if(empty($id) || empty($user_id)) {
            return false;
        }
        return ReservationDAO::confirmerReservation($id, $user_id);
    }
}