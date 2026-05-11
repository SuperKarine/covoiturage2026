<?php
namespace Models;

class Model
{
    protected ?\PDO $pdo = null;

    public function __construct()
    {
        if ($this->pdo === null) {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');

            $this->pdo = new \PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                $user,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]
            );
        }
    }

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }
}