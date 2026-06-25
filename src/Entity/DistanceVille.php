<?php

namespace Entity;

class DistanceVille
{
    private int $id_distance_ville;
    private int $id_ville_depart;
    private int $id_ville_arrivee;
    private float $km;

    public function __construct(
        int $id_ville_depart,
        int $id_ville_arrivee,
        float $km
    ) {
        $this->id_ville_depart = $id_ville_depart;
        $this->id_ville_arrivee = $id_ville_arrivee;
        $this->km = $km;
    }

    public function setIdDistanceVille(int $id_distance_ville): void
    {
        $this->id_distance_ville = $id_distance_ville;
    }

    public function getIdDistanceVille(): int {return $this->id_distance_ville;}
    public function getIdVilleDepart(): int {return $this->id_ville_depart;}
    public function getIdVilleArrivee(): int {return $this->id_ville_arrivee;}
    public function getKm(): float {return $this->km;}
}