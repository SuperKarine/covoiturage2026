<?php

namespace Entity;

enum StatutDemandeChauffeur: string
{
    case EN_ATTENTE = 'en_attente';
    case ACCEPTEE = 'acceptee';
    case REFUSEE = 'refusee';
}