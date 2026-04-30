<?php
namespace Models;

use Models\Model;

class UtilisateursModel extends Model
{
    protected string $table = 'users';


    //Pour retourner tous les utilisateurs
    public function getAll(): array
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // Pour avoir un identifiant unique
    public function findByUsername(string $username)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Pour avoir une adresse email unique
    public function findByEmail(string $email)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }



}