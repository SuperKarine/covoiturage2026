<?php

namespace Entity;

enum StatutTransaction: string
{
    case VALIDE = 'validé';
    case EN_ATTENTE = 'en attente';
    case ANNULEE = 'annulée';
}