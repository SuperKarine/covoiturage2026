<?php

namespace Entity;
use Exception;


class Trajet
{
    private int $id_trajet;
    private Utilisateurs $chauffeur;
    private string $depart;
    private string $arrivee;
    private int $placesDisponibles;
    private float $prix;

    public function __construct(
        Utilisateurs $chauffeur, string $depart,
        string $arrivee, int $places, float $prix
    ) {
        $this->chauffeur = $chauffeur;
        $this->depart = $depart;
        $this->arrivee = $arrivee;
        $this->placesDisponibles = $places;
        $this->prix = $prix;
    }

    public function setIdTrajet(int $id_trajet): void
    {
        $this->id_trajet = $id_trajet;
    }

    public function getIdTrajet(): int {return $this->id_trajet;}
    public function getChauffeur(): Utilisateurs {return $this->chauffeur;}
    public function getPrix(): float {return $this->prix;}
    public function getPlacesDisponibles(): int {return $this->placesDisponibles;}
    public function getDepart(): string {return $this->depart;}
    public function getArrivee(): string {return $this->arrivee;}

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