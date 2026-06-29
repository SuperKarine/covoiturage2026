<?php

namespace Entity;
use Exception;

class Reservation
{
    private int $id_reservation;
    private Trajet $trajet;
    private Utilisateurs $passager;
    private int $nombrePlaces;
    private StatutReservation $statut;

    public function __construct(Trajet $trajet, Utilisateurs $passager, int $nombrePlaces)
    {
        $this->trajet = $trajet;
        $this->passager = $passager;
        $this->nombrePlaces = $nombrePlaces;
        $this->statut = StatutReservation::EN_ATTENTE;
    }

    public function confirmer(Compte $comptePassager, Compte $compteChauffeur): void
    {
        $prixTotal = $this->trajet->getPrix() * $this->nombrePlaces;

        // Lève une Exception si solde insuffisant
        $comptePassager->debiter($prixTotal);
        $compteChauffeur->crediter($prixTotal);

        $this->statut = StatutReservation::CONFIRMEE;
        $this->trajet->reserverPlace($this->nombrePlaces);
    }

    public function annuler(Compte $comptePassager, Compte $compteChauffeur): void
    {
        if ($this->statut === StatutReservation::ANNULEE) {
            throw new Exception("Réservation déjà annulée.");
        }
        if ($this->statut === StatutReservation::CONFIRMEE) {
            $prixTotal = $this->trajet->getPrix() * $this->nombrePlaces;
            $comptePassager->crediter($prixTotal);
            $compteChauffeur->debiter($prixTotal);
            $this->trajet->libererPlaces($this->nombrePlaces);
        }
        $this->statut = StatutReservation::ANNULEE;
    }

    public function refuser(): void
    {
        if ($this->statut !== StatutReservation::EN_ATTENTE) {
            throw new Exception("On ne peut refuser qu'une réservation en attente.");
        }
        $this->statut = StatutReservation::REFUSEE;
    }

    public function setIdReservation(int $id_reservation): void
    {
        $this->id_reservation = $id_reservation;
    }

    public function setStatut(StatutReservation $statut): void
    {
        $this->statut = $statut;
    }

    public function getIdReservation(): int
    {
        return $this->id_reservation;
    }

    public function getStatut(): StatutReservation {return $this->statut;}
    public function getTrajet(): Trajet {return $this->trajet;}
    public function getPassager(): Utilisateurs {return $this->passager;}
    public function getNombrePlaces(): int {return $this->nombrePlaces;}
}