<?php

namespace Router;

class PanierReservation
{
    private int $id_trajet;
    private float $totalTrajet;
    private float $prixTotalTrajet;

    public function __construct(int $id_trajet, float $totalTrajet, float $prixTotalTrajet)
    {
        $this->id_trajet = $id_trajet;
        $this->totalTrajet = $totalTrajet;
        $this->prixTotalTrajet = $prixTotalTrajet;
    }

    public function getPrixTotalTrajet(): float
    {
        return $this->prixTotalTrajet;
    
    }

    public function setPrixTotalTrajet(float $price): void
    {
        $this->prixTotalTrajet = $price;
    
    }

}