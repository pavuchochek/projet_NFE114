<?php
require_once '../models/Cours.php';
require_once '../models/Coach.php';
require_once '../models/Salle.php';
require_once '../models/Database.php';

class CoursDAO {

    public static function getCoursById($id_cours) {
        $query = "SELECT c.*, co.*, s.* FROM cours c 
                  JOIN coach co ON c.id_coach = co.id_coach 
                  JOIN salle s ON c.id_salle = s.id_salle
                  WHERE c.id_cours = :id_cours";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_cours', $id_cours);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['id_coach'], $row['nom_coach'], $row['mail_coach']);
            $salle = new Salle($row['id_salle'], $row['nom_salle'], $row['capacite_salle']);
            return new Cours($row['id_cours'], $row['nom_cours'], $row['description_cours'], $row['type_cours'], $coach, $salle, $row['date_heure'], $row['capacite_cours'], $row['duree_cours']);
        }
        return null;
    }
    /**
     * Recupere tous les cours disponibles non réservés pour un adhérent donné qui ne sont pas passés
     */
    public static function getAllCoursForAdherent($id_adherent) {
        $query = "SELECT c.*, co.*, s.* FROM cours c 
                  JOIN coach co ON c.id_coach = co.id_coach 
                  JOIN salle s ON c.id_salle = s.id_salle
                  WHERE c.id_cours NOT IN (SELECT id_cours FROM reservation WHERE id_adherent = :id_adherent AND statut = 'confirmé')"
                  . " AND c.date_heure > NOW()";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_adherent', $id_adherent);
        $stmt->execute();
        $coursList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['id_coach'], $row['nom_coach'], $row['mail_coach']);
            $salle = new Salle($row['id_salle'], $row['nom_salle'], $row['capacite_salle']);
            $cours = new Cours($row['id_cours'], $row['nom_cours'], $row['description_cours'], $row['type_cours'], $coach, $salle, $row['date_heure'], $row['capacite_cours'], $row['duree_cours']);
            $coursList[] = $cours;
        }
        return $coursList;
    }

    /**
     * Recupere tous les cours attribués à un coach donné qui ne sont pas passés
     */
    public static function getAllCoursForCoach($id_coach) {
        $query = "SELECT c.*, co.*, s.* FROM cours c 
                  JOIN coach co ON c.id_coach = co.id_coach 
                  JOIN salle s ON c.id_salle = s.id_salle
                  WHERE c.id_coach = :id_coach AND c.date_heure > NOW()";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_coach', $id_coach);
        $stmt->execute();
        $coursList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['id_coach'], $row['nom_coach'], $row['mail_coach']);
            $salle = new Salle($row['id_salle'], $row['nom_salle'], $row['capacite_salle']);
            $cours = new Cours($row['id_cours'], $row['nom_cours'], $row['description_cours'], $row['type_cours'], $coach, $salle, $row['date_heure'], $row['capacite_cours'], $row['duree_cours']);
            $coursList[] = $cours;
        }
        return $coursList;
    }

    /**
     * Recupere tous les cours pour un admin
     */
    public static function getAllCoursForAdmin() {
        $query = "SELECT c.*, co.*, s.* FROM cours c 
                  JOIN coach co ON c.id_coach = co.id_coach 
                  JOIN salle s ON c.id_salle = s.id_salle;";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->execute();
        $coursList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['id_coach'], $row['nom_coach'], $row['mail_coach']);
            $salle = new Salle($row['id_salle'], $row['nom_salle'], $row['capacite_salle']);
            $cours = new Cours($row['id_cours'], $row['nom_cours'], $row['description_cours'], $row['type_cours'], $coach, $salle, $row['date_heure'], $row['capacite_cours'], $row['duree_cours']);
            $coursList[] = $cours;
        }
        return $coursList;
    }

    public static function getCoursByType(mixed $type)
    {
        $query = "SELECT c.*, co.*, s.* FROM cours c 
                  JOIN coach co ON c.id_coach = co.id_coach 
                  JOIN salle s ON c.id_salle = s.id_salle
                  WHERE c.type_cours = :type_cours AND c.date_heure > NOW()";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':type_cours', $type);
        $stmt->execute();
        $coursList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['id_coach'], $row['nom_coach'], $row['mail_coach']);
            $salle = new Salle($row['id_salle'], $row['nom_salle'], $row['capacite_salle']);
            $cours = new Cours($row['id_cours'], $row['nom_cours'], $row['description_cours'], $row['type_cours'], $coach, $salle, $row['date_heure'], $row['capacite_cours'], $row['duree_cours']);
            $coursList[] = $cours;
        }
        return $coursList;
    }
}