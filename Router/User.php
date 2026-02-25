<?php

namespace Router;

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