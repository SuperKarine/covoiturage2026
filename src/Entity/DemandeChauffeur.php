<?php

namespace Entity;
use Exception;
use DateTimeImmutable;

class DemandeChauffeur
{
    private int $id_demande;
    private int $id_utilisateurs;
    private StatutDemandeChauffeur $statut;
    private DateTimeImmutable $date_demande;
    private ?DateTimeImmutable $date_traitement;

    public function __construct(int $id_utilisateurs)
    {
        $this->id_utilisateurs = $id_utilisateurs;
        $this->statut = StatutDemandeChauffeur::EN_ATTENTE;
        $this->date_demande = new DateTimeImmutable();
        $this->date_traitement = null;
    }

    public function accepter(): void
    {
        if ($this->statut !== StatutDemandeChauffeur::EN_ATTENTE) {
            throw new Exception("Cette demande a déjà été traitée.");
        }
        $this->statut = StatutDemandeChauffeur::ACCEPTEE;
        $this->date_traitement = new DateTimeImmutable();
    }

    public function refuser(): void
    {
        if ($this->statut !== StatutDemandeChauffeur::EN_ATTENTE) {
            throw new Exception("Cette demande a déjà été traitée.");
        }
        $this->statut = StatutDemandeChauffeur::REFUSEE;
        $this->date_traitement = new DateTimeImmutable();
    }

    public function setIdDemande(int $id_demande): void
    {
        $this->id_demande = $id_demande;
    }

    public function setStatut(StatutDemandeChauffeur $statut): void
    {
        $this->statut = $statut;
    }

    public function setDateTraitement(?DateTimeImmutable $date_traitement): void
    {
        $this->date_traitement = $date_traitement;
    }

    public function getIdDemande(): int {return $this->id_demande;}
    public function getIdUtilisateurs(): int {return $this->id_utilisateurs;}
    public function getStatut(): StatutDemandeChauffeur {return $this->statut;}
    public function getDateDemande(): DateTimeImmutable {return $this->date_demande;}
    public function getDateTraitement(): ?DateTimeImmutable {return $this->date_traitement;}
}