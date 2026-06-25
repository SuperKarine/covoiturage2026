<?php

namespace Entity;
use Exception;
use DateTimeImmutable;


class Trajet
{
    private int $id_trajet;
    private Utilisateurs $chauffeur;
    private int $id_ville_depart;
    private int $id_ville_arrivee;
    private int $id_voiture;
    private int $placesDisponibles;
    private float $prix;
    private bool $fumeur;
    private bool $animaux;
    private DateTimeImmutable $date_depart;

    public function __construct(
        Utilisateurs $chauffeur,
        int $id_ville_depart,
        int $id_ville_arrivee,
        int $id_voiture,
        int $places,
        float $prix,
        bool $fumeur,
        bool $animaux,
        DateTimeImmutable $date_depart
    ) {
        $this->chauffeur = $chauffeur;
        $this->id_ville_depart = $id_ville_depart;
        $this->id_ville_arrivee = $id_ville_arrivee;
        $this->id_voiture = $id_voiture;
        $this->placesDisponibles = $places;
        $this->prix = $prix;
        $this->fumeur = $fumeur;
        $this->animaux = $animaux;
        $this->date_depart = $date_depart;
    }

    public function setIdTrajet(int $id_trajet): void
    {
        $this->id_trajet = $id_trajet;
    }

    public function getIdTrajet(): int {return $this->id_trajet;}
    public function getChauffeur(): Utilisateurs {return $this->chauffeur;}
    public function getIdVilleDepart(): int {return $this->id_ville_depart;}
    public function getIdVilleArrivee(): int {return $this->id_ville_arrivee;}
    public function getIdVoiture(): int {return $this->id_voiture;}
    public function getPrix(): float {return $this->prix;}
    public function getPlacesDisponibles(): int {return $this->placesDisponibles;}
    public function isFumeur(): bool {return $this->fumeur;}
    public function isAnimaux(): bool {return $this->animaux;}
    public function getDateDepart(): DateTimeImmutable {return $this->date_depart;}

    public function reserverPlace(int $nb): void
    {
        if ($nb > $this->placesDisponibles) {
            throw new Exception("Pas assez de places disponibles.");
        }
        $this->placesDisponibles -= $nb;
    }

    public function libererPlaces(int $nb): void
    {
        $this->placesDisponibles += $nb;
    }
}