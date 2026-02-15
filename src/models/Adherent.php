<?php

class Adherent{
    private $id_adherent;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $ddn;
    private $date_adherence;

    public function __construct($id_adherent, $nom, $prenom, $email) {
        $this->id_adherent = $id_adherent;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    // Getters et setters
    public function getIdAdherent() {
        return $this->id_adherent;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function toJsonForCours() {
        return [
            'id_adherent' => $this->id_adherent,
            'nom' => $this->nom,
            'prenom' => $this->prenom
        ];
    }

    public function toJson() {
        return [
            'id_adherent' => $this->id_adherent,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'ddn' => $this->ddn,
            'date_adherence' => $this->date_adherence
        ];
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setDdn($ddn) {
        $this->ddn = $ddn;
    }

    public function setDateAdherence($date_adherence) {
        $this->date_adherence = $date_adherence;
    }

    public function beenAdherentForHowManyYears() {
        $dateAdherence = new DateTime($this->date_adherence);
        $now = new DateTime();
        $interval = $dateAdherence->diff($now);
        return $interval->y;
    }

}