<?php
public class Cours {
    private $id_cours;
    private $nom;
    private $description;
    private $type;
    private $id_coach;

    public function __construct($id_cours, $nom, $description, $type, $id_coach) {
        $this->id_cours = $id_cours;
        $this->nom = $nom;
        $this->description = $description;
        $this->type = $type;
        $this->id_coach = $id_coach;
    }

    // Getters et setters
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

    public function getIdCoach() {
        return $this->id_coach;
    }

    public function toJson() {
        return json_encode([
            'id_cours' => $this->id_cours,
            'nom' => $this->nom,
            'description' => $this->description,
            'type' => $this->type,
            'id_coach' => $this->id_coach
        ]);
    }
}