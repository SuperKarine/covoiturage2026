<?php

namespace Exceptions;



class UserException extends \Exception
{
    public static function notVerified(): static
    {
        return new static('Utilisateur Non vérifié (static)');
    }


}