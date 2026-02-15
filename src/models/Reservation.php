<?php

class Reservation {
    private Cours $cours;
    private Adherent $adherent;
    private $date_reservation;
    private $statut;

    public function __construct(Cours $cours, Adherent $adherent, $date_reservation, $statut = "en attente") {
        $this->cours = $cours;
        $this->adherent = $adherent;
        $this->date_reservation = $date_reservation;
        $this->statut = $statut;
    }

    public function getCours() {
        return $this->cours;
    }

    public function getAdherent() {
        return $this->adherent;
    }
    public function getDateReservation() {
        return $this->date_reservation;
    }
    public function getStatut() {
        return $this->statut;
    }

    public function toJson() {
        return [
            'cours' => $this->cours->toJson(),
            'adherent' => $this->adherent->toJsonForCours(),
            'date_reservation' => $this->date_reservation,
            'statut' => $this->statut
        ];
    }

    public function toArray() {
        return [
            'cours' => $this->cours->toArray(),
            'adherent' => $this->adherent->toArrayForCours(),
            'date_reservation' => $this->date_reservation,
            'statut' => $this->statut
        ];
    }
}