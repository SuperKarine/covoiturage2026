<?php

namespace Services;


use Entity\Role;


class AutorisationService
{
    public function peutModifier(Role $role): bool
    {
        return $role === Role::ADMIN;
    }

    public function peutLireSeuleument(Role $role): bool
    {
        return $role === Role::PASSAGER || $role === Role::CHAUFFEUR;
    }
}