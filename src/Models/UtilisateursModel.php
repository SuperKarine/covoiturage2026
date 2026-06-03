<?php
namespace Models;

use Models\Model;
use PDO;

class UtilisateursModel extends Model
{
    protected string $table = 'Utilisateurs';


    //Pour retourner tous les utilisateurs
    public function getAll(int $limit = 20, int $offset = 0): array|false
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table} LIMIT :limit OFFSET :offset");
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // Pour avoir un identifiant unique
    public function findByUsername(string $username): array|false
    {
        $stmt = self::$pdo->prepare("
            SELECT u.*, r.name AS role_name
            FROM {$this->table} u
            JOIN Role r ON r.id = u.id_role
            WHERE u.username = :username
        ");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
       
    }

    // Pour avoir une adresse email unique
    public function findByEmail(string $email): array|false
    {
        $stmt = self::$pdo->prepare("
            SELECT u.*, r.name AS role_name
            FROM {$this->table} u
            JOIN Role r ON r.id = u.id_role
            WHERE u.mail = :mail
        ");
        $stmt->execute([':mail' => $email]);
        return $stmt->fetch();
    }

    //Insère un nouvel utilisateur en base de données
    public function createUser(array|false $data): bool
    {
        try {
            $stmt = self::$pdo->prepare("
                INSERT INTO {$this->table} (username, mail, password, confirmation_token)
                VALUES (?, ?, ?, ?)
            ");
    
            return $stmt->execute([
                $data['username'],
                $data['mail'],
                $data['password'],
                $data['confirmation_token']
            ]);
    
        } catch (\PDOException $e) {
            
            if ($e->getCode() === '23000') {
                return false;
            }
            throw $e; 
        }
    }

    // Confirme le compte via le token reçu par email
    public function confirmUser(string $token): bool
    {
        $stmt = self::$pdo->prepare("
            UPDATE {$this->table}
            SET is_confirmed = 1, confirmation_token = NULL
            WHERE confirmation_token = ? AND is_confirmed = 0
        ");
        $stmt->execute([$token]);
        return $stmt->rowCount() > 0;
    }

}