<?php
namespace Models;

class Model
{
    protected static ?\PDO $pdoRead = null;
    protected static ?\PDO $pdoWrite = null;

    public function getPDO(string $mode = 'read'): \PDO
    {
        if ($mode === 'write') {
            return $this->getWritePDO();
        }

        return $this->getReadPDO();
    }

    private function getReadPDO(): \PDO
    {
        if (self::$pdoRead === null) {
            self::$pdoRead = $this->createConnection(
                getenv('DB_USER_READ'),
                getenv('DB_PASS_READ')
            );
        }

        return self::$pdoRead;
    }

    private function getWritePDO(): \PDO
    {
        if (self::$pdoWrite === null) {
            self::$pdoWrite = $this->createConnection(
                getenv('DB_USER_WRITE'),
                getenv('DB_PASS_WRITE')
            );
        }

        return self::$pdoWrite;
    }

    private function createConnection(string $user, string $password): \PDO
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = getenv('DB_NAME');

        return new \PDO(
            "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
            $user,
            $password,
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]
        );
    }
}