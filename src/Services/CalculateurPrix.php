<?php

namespace Services;

class CalculateurPrix
{
    // Prix de base : 0.08€ par km
    private const PRIX_PAR_KM = 0.08;

    // Frais fixes quelle que soit la distance
    private const FRAIS_FIXES = 2.00;

    // Réduction selon le nombre de places proposées
    // (plus le chauffeur propose de places, moins c'est cher par passager)
    private const REDUCTION_PLACES = [
        1 => 0, // 0% de réduction
        2 => 0.05, // 5% de réduction
        3 => 0.10, // 10% de réduction
        4 => 0.15, // 15% de réduction
    ];

    public function calculer(float $km, int $nombrePlaces): float
    {
        // Prix de base = frais fixes + (km × prix au km)
        $prixBrut = self::FRAIS_FIXES + ($km * self::PRIX_PAR_KM);

        // J'applique la réduction selon le nombre de places
        $reduction = self::REDUCTION_PLACES[$nombrePlaces] ?? 0;
        $prixFinal = $prixBrut * (1 - $reduction);

        // J'arrondis à 2 décimales
        return round($prixFinal, 2);
    }
}