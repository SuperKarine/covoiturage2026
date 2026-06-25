<?php

namespace Entity;


enum Role: string
{
    case ADMIN = 'admin';
    case PASSAGER = 'passager';
    case CHAUFFEUR = 'chauffeur';
}