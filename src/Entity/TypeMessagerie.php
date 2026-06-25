<?php

namespace Entity;


enum TypeMessagerie: string
{
    case INSCRIPTION = 'inscription';
    case RESET = 'reset';
    case COMPTE = 'compte';
    case AUTRE = 'Autre';
}