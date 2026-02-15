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
            $coachs[] = new Coach($row['id_coach'], $row['nom'], $row['prenom'], $row['email']);
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
}