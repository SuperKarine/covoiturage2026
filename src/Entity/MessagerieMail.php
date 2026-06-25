<?php

namespace Entity;


class MessagerieMail
{
    private int $id_messagerie_mail;
    private TypeMessagerie $type;
    private string $sujet;
    private string $contenu;
    private \DateTimeImmutable $date_envoi;
    private StatutMessagerie $statut;
    private int $id_utilisateurs;
    private int $id_reservation;

    public function __construct(
        TypeMessagerie $type,
        string $sujet,
        string $contenu,
        \DateTimeImmutable $date_envoi,
        StatutMessagerie $statut,
        int $id_utilisateurs,
        int $id_reservation
    ) {
        $this->type = $type;
        $this->sujet = $sujet;
        $this->contenu = $contenu;
        $this->date_envoi = $date_envoi;
        $this->statut = $statut;
        $this->id_utilisateurs = $id_utilisateurs;
        $this->id_reservation = $id_reservation;
    }

    public function setIdMessagerieMail(int $id_messagerie_mail): void
    {
        $this->id_messagerie_mail = $id_messagerie_mail;
    }

    public function getIdMessagerieMail(): int {return $this->id_messagerie_mail;}
    public function getType(): TypeMessagerie {return $this->type;}
    public function getSujet(): string {return $this->sujet;}
    public function getContenu(): string {return $this->contenu;}
    public function getDateEnvoi(): \DateTimeImmutable {return $this->date_envoi;}
    public function getStatut(): StatutMessagerie {return $this->statut;}
    public function getIdUtilisateurs(): int {return $this->id_utilisateurs;}
    public function getIdReservation(): int {return $this->id_reservation;}
}