<?php

namespace Entity;


class Ville
{
    private int $id_ville;
    private string $nom_ville;

    public function __construct(string $nom_ville)
    {
        $this->nom_ville = $nom_ville;
    }

    public function setIdVille(int $id_ville): void
    {
        $this->id_ville = $id_ville;
    }

    public function getIdVille(): int {return $this->id_ville;}
    public function getNomVille(): string {return $this->nom_ville;}
}