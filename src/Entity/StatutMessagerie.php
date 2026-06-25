<?php

namespace Entity;


enum StatutMessagerie: string
{
    case ENVOYE = 'envoye';
    case BROUILLON = 'Brouillon';
    case RECU = 'reçu';
}