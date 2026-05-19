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
        $stmt = self::$pdo->prepare("SELECT id, username, email FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Pour avoir une adresse email unique
    public function findByEmail(string $email): array|false
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table} WHERE mail = ?");
        $stmt->execute([$email]);
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
}