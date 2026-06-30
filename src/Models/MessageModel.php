<?php

namespace Models;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;


class MessageModel extends MongoModel
{
    private \MongoDB\Collection $collection;

    public function __construct()
    {
        parent::__construct();
        $this->collection = $this->getCollection('messages');
    }

    
    // Crée un nouveau message.
     
    public function create(int $idExpediteur, int $idDestinataire, string $contenu): string
    {
        $result = $this->collection->insertOne([
            'id_expediteur' => $idExpediteur,
            'id_destinataire' => $idDestinataire,
            'contenu' => $contenu,
            'lu' => false,
            'date_envoi' => new UTCDateTime(),
        ]);

        return (string) $result->getInsertedId();
    }

    
    // Récupère un message précis par son ID.
     
    public function findById(string $id): ?array
    {
        $message = $this->collection->findOne(['_id' => new ObjectId($id)]);

        return $message ? (array) $message : null;
    }

    /**
     * Je récupère tous les messages échangés entre deux utilisateurs
     * triés du plus ancien au plus récent.
     */

    public function findEntreUtilisateurs(int $idUtilisateur1, int $idUtilisateur2): array
    {
        $cursor = $this->collection->find(
            [
                '$or' => [
                    ['id_expediteur' => $idUtilisateur1, 'id_destinataire' => $idUtilisateur2],
                    ['id_expediteur' => $idUtilisateur2, 'id_destinataire' => $idUtilisateur1],
                ],
            ],
            ['sort' => ['date_envoi' => 1]]
        );

        return $this->cursorToArray($cursor);
    }

    
    // Je récupère tous les messages reçus par un utilisateur (boîte de réception).
     
    public function findRecus(int $idUtilisateur): array
    {
        $cursor = $this->collection->find(
            ['id_destinataire' => $idUtilisateur],
            ['sort' => ['date_envoi' => -1]]
        );

        return $this->cursorToArray($cursor);
    }

    /**
    * Récupère tous les messages envoyés ou reçus par un chauffeur,
    * tous interlocuteurs confondus (boîte de réception + envoyés).
    */
    
    public function findTousPourUtilisateur(int $idUtilisateur): array
    {
        $cursor = $this->collection->find(
            [
                '$or' => [
                    ['id_expediteur' => $idUtilisateur],
                    ['id_destinataire' => $idUtilisateur],
                ],
            ],
            ['sort' => ['date_envoi' => -1]]
        );

        return $this->cursorToArray($cursor);
    }

    
    // Insère plusieurs messages en une seule opération.
    
    public function insertMany(array $messages): array
    {
        $result = $this->collection->insertMany($messages);

        $ids = [];

        foreach ($result->getInsertedIds() as $id) {
            $ids[] = (string) $id;
        }

    return $ids;
}

    
    // Marque un message comme lu.
     
    public function marquerCommeLu(string $id): bool
    {
        $result = $this->collection->updateOne(
            ['_id' => new ObjectId($id)],
            ['$set' => ['lu' => true]]
        );

        return $result->getModifiedCount() > 0;
    }

    
    // Supprime un message.
     
    public function delete(string $id): bool
    {
        $result = $this->collection->deleteOne(['_id' => new ObjectId($id)]);

        return $result->getDeletedCount() > 0;
    }

    
    // Convertit un curseur Mongo en tableau PHP simple, avec _id en string.
     
    private function cursorToArray($cursor): array
    {
        $messages = [];

        foreach ($cursor as $document) {
            $message = (array) $document;
            $message['_id'] = (string) $message['_id'];
            $message['date_envoi'] = $message['date_envoi']->toDateTime()->format('Y-m-d H:i:s');
            $messages[] = $message;
        }

        return $messages;
    }
}