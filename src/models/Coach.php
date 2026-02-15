<?php

class Coach {
    private $id_coach;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $ddn;
    private $prix_heure;

    public function __construct($id_coach, $nom, $prenom, $email, $telephone = null, $ddn = null, $prix_heure = null) {
        $this->id_coach = $id_coach;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->ddn = $ddn;
        $this->prix_heure = $prix_heure;
    }

    // Getters et setters
    public function getIdCoach() {
        return $this->id_coach;
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

    public function toJsonForCours() {
        return [
            'id_coach' => $this->id_coach,
            'nom' => $this->nom,
            'prenom' => $this->prenom
        ];
    }

    public function toJson() {
        $json = $this->toJson();
        return json_encode($json);
    }
    public function toArray(): array
    {
        return [
            'id_coach' => $this->id_coach,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'ddn' => $this->ddn,
            'prix_heure' => $this->prix_heure
        ];
    }
}