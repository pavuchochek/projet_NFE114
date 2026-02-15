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
        return ReservationDAO::createReservation($cours_id, $adherent_id);
    }

    public static function annulerReservation($id, $userId) {
       return ReservationDAO::annulerReservation($id, $userId);
    }

    public static function confirmerReservation(mixed $id, $user_id)
    {
        return ReservationDAO::confirmerReservation($id, $user_id);
    }
}