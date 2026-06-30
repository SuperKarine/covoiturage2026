<?php
namespace Models;

use Models\Model;
use PDO;

class UtilisateursModel extends Model
{
    protected string $table = 'Utilisateurs';

    // Pour retourner tous les utilisateurs
    public function getAll(int $limit = 20, int $offset = 0): array|false
    {
        $stmt = $this->getPDO('read')->prepare("SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pour avoir un identifiant unique
    public function findByUsername(string $username): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT u.*, r.name AS role_name
            FROM {$this->table} u
            JOIN Role r ON r.id_role = u.id_role
            WHERE u.username = :username
        ");
        $stmt->execute([':username' => $username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pour avoir une adresse email unique
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT u.*, r.name AS role_name
            FROM {$this->table} u
            JOIN Role r ON r.id_role = u.id_role
            WHERE u.mail = :mail
        ");
        $stmt->execute([':mail' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insère un nouvel utilisateur en base de données
    public function createUser(array|false $data): bool
    {
        try {
            $pdo = $this->getPDO('write');
            $pdo->beginTransaction();

            // Création du compte avec un solde à 0
            $stmtCompte = $pdo->prepare("
                INSERT INTO Compte (solde) VALUES (0)
            ");
            $stmtCompte->execute();
            $idCompte = $pdo->lastInsertId();

            // Création de l'utilisateur en liant le compte créé
            $stmt = $pdo->prepare("
                INSERT INTO {$this->table} (nom, prenom, tel, username, mail, password, confirmation_token, is_confirmed, id_role, id_compte)
                VALUES (?, ?, ?, ?, ?, ?, ?, 0, 2, ?)
            ");

            $stmt->execute([
                $data['nom'],
                $data['prenom'],
                $data['tel'],
                $data['username'],
                $data['mail'],
                $data['password'],
                $data['confirmation_token'],
                $idCompte
            ]);

            $pdo->commit();
            return true;

        } catch (\PDOException $e) {
            $pdo->rollBack();

            if ($e->getCode() === '23000') {
                return false;
            }
            throw $e;
        }
    }

    // Confirme le compte via le token reçu par email
    public function confirmUser(string $token): bool
    {
        $stmt = $this->getPDO('write')->prepare("
            UPDATE {$this->table}
            SET is_confirmed = 1, confirmation_token = NULL
            WHERE confirmation_token = ? AND is_confirmed = 0
        ");
        $stmt->execute([$token]);
        return $stmt->rowCount() > 0;
    }

    // Pour récupérer un utilisateur précis par son ID
    public function findById(int $id): array|false
    {
        $stmt = $this->getPDO('read')->prepare("
            SELECT u.*, r.name AS role_name
            FROM {$this->table} u
            JOIN Role r ON r.id_role = u.id_role
            WHERE u.id_utilisateurs = :id
        ");

        $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}