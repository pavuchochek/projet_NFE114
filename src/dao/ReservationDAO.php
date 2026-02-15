<?php
require_once '../models/Database.php';
require_once '../models/Reservation.php';
require_once '../models/Cours.php';
require_once '../models/Adherent.php';


class ReservationDAO {
    /**
     * Recupere les reservations d'un adherent actuelles (non passées) avec les infos du cours associé
     */
    public static function getReservationsByAdherent($id_adherent) {
        $pdo = Database::getConnection();
        $query = "SELECT p.* FROM participe p JOIN Cours c ON p.id_cours = c.id_cours WHERE p.id_adherent = :id_adherent AND c.date_heure > NOW()";
        $stmt = $pdo->prepare($query);
        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = new Reservation($row['id_reservation'], $row['id_adherent'], $row['id_coach'], $row['date_reservation']);
        }
        return $reservations;
    }

    public static function getReservationsPassedByAdherent($id_adherent) {
        $pdo = Database::getConnection();
        $query = "SELECT p.* FROM participe p JOIN Cours c ON p.id_cours = c.id_cours WHERE p.id_adherent = :id_adherent AND c.date_heure <= NOW()";
        $stmt = $pdo->prepare($query);
        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = new Reservation($row['id_reservation'], $row['id_adherent'], $row['id_coach'], $row['date_reservation']);
        }
        return $reservations;
    }


    public static function createReservation($id_adherent, $id_cours) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO participe (id_adherent, id_cours, date_reservation, statut) VALUES (:id_adherent, :id_cours, NOW(), 'en attente')");
        $stmt->execute(['id_adherent' => $id_adherent, 'id_cours' => $id_cours]);
        return $pdo->lastInsertId();
    }

    public static function cancelReservation($id_reservation) {
        $pdo = Database::getConnection();
        $query = "UPDATE participe SET statut = 'annulé' WHERE id_reservation = :id_reservation";
        $stmt = $pdo->prepare($query);
        return $stmt->execute(['id_reservation' => $id_reservation]);
    }

    public static function confirmReservation($id_reservation) {
        $pdo = Database::getConnection();
        $query = "UPDATE participe SET statut = 'confirmé' WHERE id_reservation = :id_reservation";
        $stmt = $pdo->prepare($query);
        return $stmt->execute(['id_reservation' => $id_reservation]);
    }
}