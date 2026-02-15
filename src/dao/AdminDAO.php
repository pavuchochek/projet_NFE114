<?php

require '../models/Cours.php';
require '../models/Adherent.php';
require '../models/Coach.php';
require '../models/Salle.php';

class AdminDAO {
    /**
     * Recupere le cout par seance effectué par chaque coach
     */
    public static function getPrixParCoachParSeance() {
        $pdo = Database::getConnection();
        //todo
    }
}