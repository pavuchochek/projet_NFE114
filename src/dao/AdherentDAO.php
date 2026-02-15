<?php
require_once '../models/Database.php';
require_once '../models/Adherent.php';

class AdherentDAO {
   public static function getAdherentById($id): ?Adherent
   {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(" SELECT a.id_adherent as id_adherent, a.nom as nom_adherent, a.prenom as prenom_adherent, a.mail as mail_adherent
                                FROM adherent a
                                WHERE id_adherent = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Adherent($row['id_adherent'], $row['nom_adherent'], $row['prenom_adherent'], $row['mail_adherent']);
        }
        return null;
    }

    public static function getAllAdherents(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM adherent");
        $adherents = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adherents[] = new Adherent($row['id_adherent'], $row['nom'], $row['prenom'], $row['email']);
        }
        return $adherents;
    }

    public static function getAdherentProfile($id): ?Adherent
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM adherent WHERE id_adherent = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $adherent = new Adherent($row['id_adherent'], $row['nom'], $row['prenom'], $row['mail']);
            $adherent->setTelephone($row['telephone']);
            $adherent->setDdn($row['ddn']);
            $adherent->setDateAdherence($row['date_adherence']);
            return $adherent;
        }
        return null;
    }

    public static function getAdherentsByCoursId($id_cours) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT a.* FROM adherent a JOIN participe i ON a.id_adherent = i.id_adherent WHERE i.id_cours = :id_cours");
        $stmt->execute(['id_cours' => $id_cours]);
        $adherents = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adherents[] = new Adherent($row['id_adherent'], $row['nom'], $row['prenom'], $row['email']);
        }
        return $adherents;
    }
}