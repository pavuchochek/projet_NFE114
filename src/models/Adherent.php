<?php

class Adherent{
    private $id_adherent;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $ddn;
    private $date_adherence;

    private $statut_participation;

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

    public function setStatutParticipation($statut) {
        $this->statut_participation = $statut;
    }

    public function toJsonForCours() {
        return [
            'id_adherent' => $this->id_adherent,
            'nom' => $this->nom,
            'prenom' => $this->prenom
        ];
    }

    public function toArrayForCours(): array
    {
        $data = [
            'id_adherent' => $this->id_adherent,
            'nom' => $this->nom,
            'prenom' => $this->prenom
        ];
        if (isset($this->statut_participation)) {
            $data['statut_participation'] = $this->statut_participation;
        }
        return $data;
    }

    public function toArray() {
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