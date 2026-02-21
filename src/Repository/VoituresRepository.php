<?php
namespace App\Repository;

use App\Entity\Voitures;
use App\Db\MongoDB;

class VoituresRepository
{
    private $collection;

    public function __construct()
    {
        $mongoDB = MongoDB::getInstance();
        $this->collection = $mongoDB->getCollection('vehicules');
    }

    // CREATE
    public function create(Voitures $voiture): string
    {
        $data = $voiture->toArray();
        $result = $this->collection->insertOne($data);
        return (string)$result->getInsertedId();
    }

    // READ - Tous les véhicules
    public function getAll(): array
    {
        $documents = $this->collection->find([], [
            'sort' => ['marque' => 1, 'modele' => 1]
        ]);

        $voitures = [];
        foreach ($documents as $document) {
            $voitures[] = Voitures::fromDocument($document);
        }

        return $voitures;
    }

    // READ - Véhicules écologiques seulement
    public function getEcologiques(): array
    {
        $documents = $this->collection->find([
            'ecologique' => true
        ], [
            'sort' => ['marque' => 1, 'modele' => 1]
        ]);

        $voitures = [];
        foreach ($documents as $document) {
            $voitures[] = Voitures::fromDocument($document);
        }

        return $voitures;
    }

    // DELETE
    public function delete(string $id): bool
    {
        try {
            $result = $this->collection->deleteOne(['_id' => $id]);
            return $result->getDeletedCount() > 0;
        } catch (\Exception $e) {
            error_log("Erreur suppression: " . $e->getMessage());
            return false;
        }
    }

    
    public function isEcologique(string $marque, string $modele): bool
    {
        $vehiculesEcologiques = [
            'Tesla' => ['Model 3', 'Model S', 'Model X', 'Model Y'],
            'Renault' => ['Zoe', 'Twizy'],
            'Nissan' => ['Leaf'],
            'BMW' => ['i3', 'i8'],
            'Hyundai' => ['Kona Electric', 'Ioniq']
        ];

        return isset($vehiculesEcologiques[$marque]) && 
               in_array($modele, $vehiculesEcologiques[$marque]);
    }
}