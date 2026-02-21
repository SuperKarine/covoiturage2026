<?php
namespace App\Db;

use PDO;
use PDOException;
use Exception;

class Mysql
{
    private string $dbName;
    private string $dbUser;
    private string $dbPassword;
    private string $dbPort;
    private string $dbHost;

    private ?PDO $pdo = null;
    private static ?self $_instance = null;

    private function __construct()
    {
        // Récupération des variables depuis .env
        $this->dbHost = getenv('DB_HOST') ?: 'db';
        $this->dbUser = getenv('MYSQL_USER') ?: 'root';
        $this->dbPassword = getenv('MYSQL_PASSWORD') ?: '';
        $this->dbPort = getenv('DB_PORT') ?: '3306';
        $this->dbName = getenv('MYSQL_DATABASE') ?: 'app';

        // Vérification simple
        if (!$this->dbHost || !$this->dbUser || !$this->dbName) {
            throw new Exception("Paramètres de connexion à la base de données manquants ou invalides.");
        }
    }

    // Singleton
    public static function getInstance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Mysql();
        }

        return self::$_instance;
    }

    // Retourne l'objet PDO
    public function getPDO(): PDO
    {
        if (is_null($this->pdo)) {
            try {
                $dsn = "mysql:host={$this->dbHost};dbname={$this->dbName};port={$this->dbPort};charset=utf8";

                $this->pdo = new PDO(
                    $dsn,
                    $this->dbUser,
                    $this->dbPassword,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_PERSISTENT => false,
                    ]
                );
            } catch (PDOException $e) {
                error_log("Erreur PDO: " . $e->getMessage());
                throw new Exception("Impossible de se connecter à la base de données. Vérifiez vos paramètres.");
            }
        }

        return $this->pdo;
    }

    // Test pour la connexion
    public function testConnection(): bool
    {
        try {
            $this->getPDO()->query("SELECT 1");
            return true;
        } catch (Exception $e) {
            error_log("Test de connexion échoué: " . $e->getMessage());
            return false;
        }
    }
}
