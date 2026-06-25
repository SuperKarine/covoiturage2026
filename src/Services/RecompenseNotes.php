<?php

namespace Services;

class RecompenseNotes
{
    public function evaluerRecompense(float $moyenneNotes): string
    {
        if ($moyenneNotes >= 4.5) {
            return "Récompense obtenue !";
        }

        if ($moyenneNotes >= 4.0) {
            return "Encore un effort pour obtenir une récompense.";
        }

        return "Il va falloir faire beaucoup d'efforts.";
    }
}