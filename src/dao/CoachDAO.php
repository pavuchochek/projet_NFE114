<?php
require '../models/Database.php';
require '../models/Coach.php';

class CoachDAO {
    public static function getCoachById($id_coach) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM coach WHERE id_coach = :id_coach");
        $stmt->execute(['id_coach' => $id_coach]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Coach($row['id_coach'], $row['nom'], $row['prenom'], $row['mail']);
        }
        return null;
    }

    public static function getAllCoachs() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM coach");
        $coachs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['id_coach'], $row['nom'], $row['prenom'], $row['mail']);
            $coach->setTelephone($row['telephone']);
            $coach->setDdn($row['ddn']);
            $coach->setPrix($row['prix_heure']);
            $coachs[] = $coach;
        }
        return $coachs;
    }


    public static function getCoachProfile($id_coach) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM coach WHERE id_coach = :id_coach");
        $stmt->execute(['id_coach' => $id_coach]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $coach = new Coach($row['id_coach'], $row['nom'], $row['prenom'], $row['email']);
            $coach->setTelephone($row['telephone']);
            $coach->setDdn($row['ddn']);
            return $coach;
        }
        return null;
    }

    public static function getPaiements(): array
    {
        $pdo = Database::getConnection();

        $sql = "
        SELECT 
            co.id_coach,
            CONCAT(co.nom, ' ', co.prenom) AS coach,
            COUNT(DISTINCT c.id_cours) AS nb_seances,
            SUM(c.duree) AS total_heures,
            co.prix_heure,
            ROUND(SUM(c.duree * co.prix_heure), 2) AS total_a_payer
        FROM coach co
        JOIN cours c ON c.id_coach = co.id_coach
        JOIN participe p ON p.id_cours = c.id_cours
        WHERE 
            c.date_cours < NOW()
            AND p.statut = 'confirmé'
        GROUP BY co.id_coach, co.prix_heure
        ORDER BY total_a_payer DESC
    ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}