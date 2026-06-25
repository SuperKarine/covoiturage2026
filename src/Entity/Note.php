<?php

namespace Entity;

class Note
{
    private int $id_note;
    private ?int $note;
    private int $id_utilisateurs;
    private int $id_trajet;
    private int $id_auteur;

    public function __construct(
        ?int $note,
        int $id_utilisateurs,
        int $id_trajet,
        int $id_auteur
    ) {
        $this->note = $note;
        $this->id_utilisateurs = $id_utilisateurs;
        $this->id_trajet = $id_trajet;
        $this->id_auteur = $id_auteur;
    }

    public function setIdNote(int $id_note): void
    {
        $this->id_note = $id_note;
    }

    public function getIdNote(): int {return $this->id_note;}
    public function getNote(): ?int {return $this->note;}
    public function getIdUtilisateurs(): int {return $this->id_utilisateurs;}
    public function getIdTrajet(): int {return $this->id_trajet;}
    public function getIdAuteur(): int {return $this->id_auteur;}
}