<?php
namespace Models;

use Models\Model;
use Entity\Transaction;
use Entity\StatutTransaction;
use Entity\TypeTransaction;
use PDO;
use DateTimeImmutable;

class TransactionModel extends Model
{
    protected string $table = 'Transactions';

    /**
     * Enregistre une nouvelle transaction liée à une réservation.
     * Utilisé en dehors du flux confirmer()/annuler() de Reservation
     */

    public function create(Transaction $transaction): int|false
    {
        $pdo = $this->getPDO('write');

        $stmt = $pdo->prepare("
            INSERT INTO {$this->table}
                (date, statut, type, montant, id_compte_source, id_compte_destination, id_reservation)
            VALUES
                (:date, :statut, :type, :montant, :id_compte_source, :id_compte_destination, :id_reservation)
        ");

        $success = $stmt->execute([
            ':date' => $transaction->getDate()->format('Y-m-d H:i:s'),
            ':statut' => $transaction->getStatut()->value,
            ':type' => $transaction->getType()->value,
            ':montant' => $transaction->getMontant(),
            ':id_compte_source' => $transaction->getIdCompteSource(),
            ':id_compte_destination' => $transaction->getIdCompteDestination(),
            ':id_reservation' => $transaction->getIdReservation(),
        ]);

        return $success ? (int) $pdo->lastInsertId() : false;
    }

    
    //Récupère l'historique des transactions liées à une réservation donnée.
     
    public function findByReservation(int $idReservation): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT * FROM {$this->table}
            WHERE id_reservation = :id_reservation
            ORDER BY date ASC
        ");
        $stmt->execute([':id_reservation' => $idReservation]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tout l'historique des transactions d'un compte donné
     */
    
    public function findByCompte(int $idCompte): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT * FROM {$this->table}
            WHERE id_compte_source = :id_compte OR id_compte_destination = :id_compte2
            ORDER BY date DESC
        ");
        $stmt->execute([
            ':id_compte' => $idCompte,
            ':id_compte2' => $idCompte,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}