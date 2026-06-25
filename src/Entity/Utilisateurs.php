<?php

namespace Entity;


class Utilisateurs
{
    private int $id_utilisateurs;
    private string $email;
    private string $password;
    private Role $role;
    private Compte $compte;

    public function __construct(int $id_utilisateurs, string $email, string $password, Role $role, Compte $compte)
    {
        $this->id_utilisateurs = $id_utilisateurs;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->compte = $compte;
    }

    public function getId(): int {return $this->id_utilisateurs;}
    public function getEmail(): string {return $this->email;}
    public function getRole(): Role {return $this->role;}
    public function getCompte(): Compte {return $this->compte;}

    public function verifierMotDePasse(string $mdpSaisi): bool
    {
        return password_verify($mdpSaisi, $this->password);
    }
}