<?php

namespace Entity;
use Exception;

class Compte
{
    private int $id_compte;
    private int $id_utilisateurs;
    private float $solde;

    public function __construct(int $id_compte, int $id_utilisateurs, float $solde = 0.0)
    {
        $this->id_compte= $id_compte;
        $this->id_utilisateurs = $id_utilisateurs;
        $this->solde = $solde;
    }

    
    public function getIdCompte(): int { return $this->id_compte; }
    public function getIdUtilisateurs(): int { return $this->id_utilisateurs; }
    public function getSolde(): float {return $this->solde;}

    public function crediter(float $montant): void
    {
        $this->solde += $montant;
    }

    public function debiter(float $montant): void
    {
        if ($montant > $this->solde) {
            throw new Exception("Solde insuffisant.");
        }
        $this->solde -= $montant;
    }
}
