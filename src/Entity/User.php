<?php

namespace Entity;

class User 
{
    public function __construct(public string $username, public string $password)
    {}

        // vérifie si l'utilisateur est authentifié ou pas
    public function isVerified(): bool
    {
        return false;
    }

    public function isBan(): bool
    {
        return false;
    }
   
    
}