<?php

namespace Router;

use Exceptions\UserException;
use Router\User;


class Login
{
    public function __construct(protected User $user)
    {
        
    }

    // Login pour permettre une connexion à mon utilisateur
    public function login(): bool
    {
        //Si mon utilisateur n'est pas connecté, je ne le connecte pas
        if (!$this->user->isVerified()) {
            //throw new UserNotVerifiedException();

            throw UserException::notVerified();
        }

    
        return true;
    }
}