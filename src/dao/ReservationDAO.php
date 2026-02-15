<?php
require_once '../models/Database.php';
require_once '../models/Reservation.php';
require_once '../models/Cours.php';
require_once '../models/Adherent.php';
require_once '../dao/CoursDAO.php';
require_once '../dao/AdherentDAO.php';


class ReservationDAO {
    /**
     * Recupere les reservations d'un adherent actuelles (non passées) avec les infos du cours associé
     */
    public static function getAllReservations($id_adherent) {
        $pdo = Database::getConnection();
        $query = "SELECT p.id_adherent as id_adherent, p.id_cours as id_cours, p.date_reservation as date_reservation, p.statut as statut
                    FROM participe p 
                    JOIN cours c ON p.id_cours = c.id_cours 
                    WHERE p.id_adherent = :id_adherent 
                    AND c.date_cours > NOW()";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_adherent', $id_adherent);
        $stmt->execute();
        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cours = CoursDAO::getCoursById($row['id_cours']);
            $adherent = AdherentDAO::getAdherentById($row['id_adherent']);
            $reservations[] = new Reservation($cours, $adherent, $row['date_reservation'], $row['statut']);
        }
        return $reservations;
    }


    public static function createReservation($id_adherent, $id_cours) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO participe (id_adherent, id_cours, date_reservation, statut) VALUES (:id_adherent, :id_cours, NOW(), 'en attente')");
        $stmt->execute(['id_adherent' => $id_adherent, 'id_cours' => $id_cours]);
        return $pdo->lastInsertId();
    }

    public static function annulerReservation($id_reservation) {
        $pdo = Database::getConnection();
        $query = "UPDATE participe SET statut = 'annulé' WHERE id_reservation = :id_reservation";
        $stmt = $pdo->prepare($query);
        return $stmt->execute(['id_reservation' => $id_reservation]);
    }

    public static function confirmerReservation($id_reservation) {
        $pdo = Database::getConnection();
        $query = "UPDATE participe SET statut = 'confirmé' WHERE id_reservation = :id_reservation";
        $stmt = $pdo->prepare($query);
        return $stmt->execute(['id_reservation' => $id_reservation]);
    }

    public static function getReservationById($id, $userId)
    {
        $pdo = Database::getConnection();
        $query = "SELECT p.* FROM participe p JOIN cours c ON p.id_cours = c.id_cours WHERE p.id_reservation = :id AND p.id_adherent = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id, 'userId' => $userId]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Reservation($row['id_reservation'], $row['id_adherent'], $row['id_coach'], $row['date_reservation']);
        }
        return null;
    }

    public static function getReservationStatutByCoursIdByUserId($id_cours, $userId)
    {
        $pdo = Database::getConnection();
        $query = "SELECT p.statut as statut
                  FROM participe p
                  JOIN cours c ON p.id_cours = c.id_cours
                  WHERE p.id_cours = :id_cours 
                  AND p.id_adherent = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id_cours' => $id_cours, 'userId' => $userId]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['statut'];
        }
        return null;
    }

}