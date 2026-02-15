<?php
require_once '../models/Cours.php';
require_once '../models/Coach.php';
require_once '../models/Salle.php';
require_once '../models/Database.php';
require_once '../dao/ReservationDAO.php';

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
    public static function getAllCoursForAdherent($id_adherent): array
    {
        $query = "SELECT 
            c.id_cours AS c_id, c.nom AS c_nom, c.description AS c_description, c.type AS c_type, c.date_cours AS c_date, c.capacite_max AS c_capacite, c.duree AS c_duree,
            co.id_coach AS co_id, co.nom AS co_nom, co.prenom AS co_prenom, co.mail AS co_mail,
            s.id_salle AS s_id, s.nom AS s_nom, s.capacite_max AS s_capacite
          FROM cours c 
          JOIN coach co ON c.id_coach = co.id_coach 
          JOIN salle s ON c.id_salle = s.id_salle
          WHERE c.id_cours NOT IN (
              SELECT id_cours 
              FROM participe 
              WHERE id_adherent = :id_adherent AND statut = 'confirmé'
          ) 
          AND c.date_cours > NOW()";

        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':id_adherent', $id_adherent, PDO::PARAM_INT);
        $stmt->execute();

        $coursList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['co_id'], $row['co_nom'], $row['co_prenom'], $row['co_mail']);
            $salle = new Salle($row['s_id'], $row['s_nom'], $row['s_capacite']);
            $cours = new Cours($row['c_id'], $row['c_nom'], $row['c_description'], $row['c_type'], $coach, $salle, $row['c_date'], $row['c_capacite'], $row['c_duree']);
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

    public static function getCoursHistoryByUserId($userId)
    {
        $query = "SELECT c.id_cours AS c_id, c.nom AS c_nom, c.description AS c_description, c.type AS c_type, c.date_cours AS c_date, c.capacite_max AS c_capacite, c.duree AS c_duree,
                         co.id_coach AS co_id, co.nom AS co_nom, co.prenom AS co_prenom, co.mail AS co_mail,
                         s.id_salle AS s_id, s.nom AS s_nom, s.capacite_max AS s_capacite
                    FROM cours c 
                  JOIN coach co ON c.id_coach = co.id_coach 
                  JOIN salle s ON c.id_salle = s.id_salle
                  JOIN participe p ON c.id_cours = p.id_cours
                  WHERE p.id_adherent = :userId AND c.date_cours <= NOW()";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $coursList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coach = new Coach($row['co_id'], $row['co_nom'], $row['co_prenom'], $row['co_mail']);
            $salle = new Salle($row['s_id'], $row['s_nom'], $row['s_capacite']);
            $cours = new Cours($row['c_id'], $row['c_nom'], $row['c_description'], $row['c_type'], $coach, $salle, $row['c_date'], $row['c_capacite'], $row['c_duree']);
            $coursList[] = $cours;
        }
        return $coursList;
    }
}