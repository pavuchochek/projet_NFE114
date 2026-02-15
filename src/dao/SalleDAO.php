<?php
require '../models/Database.php';
require '../models/Salle.php';

class SalleDAO {
    public static function getAllSalles() {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM salle");
        $stmt->execute();
        $salles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $salles[] = new Salle($row['id_salle'], $row['nom'], $row['capacite_max']);
        }
        return $salles;
    }

    public static function getSalleById($id_salle) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM salle WHERE id_salle = :id_salle");
        $stmt->execute(['id_salle' => $id_salle]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Salle($row['id_salle'], $row['nom'], $row['capacite']);
        }
        return null;
    }
}