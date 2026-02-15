<?php

class Salle {
    private $id_salle;
    private $nom;
    private $capacite;

    public function __construct($id_salle, $nom, $capacite) {
        $this->id_salle = $id_salle;
        $this->nom = $nom;
        $this->capacite = $capacite;
    }
    
    public function getIdSalle() {
        return $this->id_salle;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getCapacite() {
        return $this->capacite;
    }

    public function toJson() {
        return [
            'id_salle' => $this->id_salle,
            'nom' => $this->nom,
            'capacite' => $this->capacite
        ];
    }

    public function isSallePossible($capacite_cours) {
        return $this->capacite >= $capacite_cours;
    }
}