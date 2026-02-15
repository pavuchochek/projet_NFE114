<?php
require_once 'Coach.php';
require_once 'Salle.php';

class Cours {
    private $id_cours;
    private $nom;
    private $description;
    private $type;
    private Coach $coach;
    private Salle $salle;
    private $date_heure;
    private $capacite;
    private $duree;
    private $nb_inscrits;

    public function __construct($id_cours, $nom, $description, $type, Coach $coach, Salle $salle, $date_heure = null, $capacite = null, $duree = null, $nb_inscrits = 0) {
        $this->id_cours = $id_cours;
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->coach = $coach;
        $this->salle = $salle;
        $this->date_heure = $date_heure;
        $this->capacite = $capacite;
        $this->duree = $duree;
        $this->nb_inscrits = $nb_inscrits;
    }

    public function getIdCours() {
        return $this->id_cours;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getType() {
        return $this->type;
    }

    public function getCoach() {
        return $this->coach;
    }

    public function getSalle() {
        return $this->salle;
    }

    public function getDateHeure() {
        return $this->date_heure;
    }

    public function getCapacite() {
        return $this->capacite;
    }

    public function getDuree() {
        return $this->duree;
    }

    public function getNbInscrits() {
        return $this->nb_inscrits;
    }

    public function toJson() {
        return json_encode([
            'id_cours' => $this->id_cours,
            'nom' => $this->nom,
            'description' => $this->description,
            'type' => $this->type,
            'coach' => $this->coach->toJsonForCours(),
            'salle' => $this->salle->toJson(),
            'date_heure' => $this->date_heure,
            'capacite' => $this->capacite,
            'duree' => $this->duree,
            'nb_inscrits' => $this->nb_inscrits
        ]);
    }
}