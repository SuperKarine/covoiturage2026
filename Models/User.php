<?php
namespace Models;

use Models\Model;

class User extends Model
{
    protected string $table = 'Users';

    public function getAll(): array
    {
        $stmt = self::$pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }
}