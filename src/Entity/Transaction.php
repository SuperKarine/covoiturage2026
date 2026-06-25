<?php

namespace Entity;

class Transaction
{
    private int $id_transactions;
    private \DateTimeImmutable $date;
    private StatutTransaction $statut;
    private TypeTransaction $type;
    private float $montant;
    private int $id_compte_source;
    private int $id_compte_destination;
    private int $id_reservation;

    public function __construct(
        \DateTimeImmutable $date,
        StatutTransaction $statut,
        TypeTransaction $type,
        float $montant,
        int $id_compte_source,
        int $id_compte_destination,
        int $id_reservation
    ) {
        $this->date = $date;
        $this->statut = $statut;
        $this->type = $type;
        $this->montant = $montant;
        $this->id_compte_source = $id_compte_source;
        $this->id_compte_destination = $id_compte_destination;
        $this->id_reservation = $id_reservation;
    }

    public function annuler(): void
    {
        if ($this->statut === StatutTransaction::ANNULEE) {
            throw new \Exception("Transaction déjà annulée.");
        }
        $this->statut = StatutTransaction::ANNULEE;
    }

    public function setIdTransactions(int $id_transactions): void
    {
        $this->id_transactions = $id_transactions;
    }

    public function getIdTransactions(): int {return $this->id_transactions;}
    public function getDate(): \DateTimeImmutable {return $this->date;}
    public function getStatut(): StatutTransaction {return $this->statut;}
    public function getType(): TypeTransaction {return $this->type;}
    public function getMontant(): float {return $this->montant;}
    public function getIdCompteSource(): int {return $this->id_compte_source;}
    public function getIdCompteDestination(): int {return $this->id_compte_destination;}
    public function getIdReservation(): int {return $this->id_reservation;}
}