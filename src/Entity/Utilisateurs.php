<?php

namespace Entity;

class Utilisateurs
{
    private int $id_utilisateurs;
    private string $nom;
    private string $prenom;
    private string $tel;
    private string $username;
    private string $mail;
    private string $password;
    private ?string $confirmation_token;
    private bool $is_confirmed;
    private Role $role;
    private Compte $compte;

    public function __construct(
        string $nom,
        string $prenom,
        string $tel,
        string $username,
        string $mail,
        string $password,
        ?string $confirmation_token,
        bool $is_confirmed,
        Role $role,
        Compte $compte
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->tel = $tel;
        $this->username = $username;
        $this->mail = $mail;
        $this->password = $password;
        $this->confirmation_token = $confirmation_token;
        $this->is_confirmed = $is_confirmed;
        $this->role = $role;
        $this->compte = $compte;
    }

    public function setIdUtilisateurs(int $id_utilisateurs): void
    {
        $this->id_utilisateurs = $id_utilisateurs;
    }

    public function getIdUtilisateurs(): int {return $this->id_utilisateurs;}
    public function getNom(): string {return $this->nom;}
    public function getPrenom(): string {return $this->prenom;}
    public function getTel(): string {return $this->tel;}
    public function getUsername(): string {return $this->username;}
    public function getMail(): string {return $this->mail;}
    public function getConfirmationToken(): ?string {return $this->confirmation_token;}
    public function isConfirmed(): bool {return $this->is_confirmed;}
    public function getRole(): Role {return $this->role;}
    public function getCompte(): Compte {return $this->compte;}

    public function verifierMotDePasse(string $mdpSaisi): bool
    {
        return password_verify($mdpSaisi, $this->password);
    }
}