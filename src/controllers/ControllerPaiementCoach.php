<?php
require_once("../dao/CoachDAO.php");
class ControllerPaiementCoach{
    public static function getPaiements()
    {
        $paiements = [];
        $paiements = CoachDAO::getPaiements();

        return $paiements;
    }
}