<?php

namespace Entity;


class Voiture
{
    private int $id_voiture;
    private string $modele;
    private int $nb_places;
    private string $energie;

    public function __construct(
        string $modele,
        int $nb_places,
        string $energie
    ) {
        $this->modele = $modele;
        $this->nb_places = $nb_places;
        $this->energie = $energie;
    }

    public function setIdVoiture(int $id_voiture): void
    {
        $this->id_voiture = $id_voiture;
    }

    public function getIdVoiture(): int {return $this->id_voiture;}
    public function getModele(): string {return $this->modele;}
    public function getNbPlaces(): int {return $this->nb_places;}
    public function getEnergie(): string {return $this->energie;}
}