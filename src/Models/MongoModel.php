<?php

namespace Models;

use MongoDB\Client;
use MongoDB\Database;
use MongoDB\Collection;

class MongoModel
{
    protected static ?Client $client = null;
    protected static ?Database $database = null;

    public function __construct()
    {
        if (self::$client === null) {
            $uri = getenv('MONGO_URI') ?: 'mongodb://localhost:27017';
            $dbName = getenv('MONGO_DB') ?: 'covoiturage';

            self::$client = new Client($uri);
            self::$database = self::$client->selectDatabase($dbName);
        }
    }

    public static function getDatabase(): Database
    {
        return self::$database;
    }

    protected function getCollection(string $name): Collection
    {
        return self::$database->selectCollection($name);
    }
}