<?php

namespace Controllers;

use Models\MessageModel;


class MessageController
{
    private MessageModel $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    /**
     * POST /api/messages
     * Envoie un nouveau message
     */

    public function create(): string
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['id_expediteur'], $data['id_destinataire'], $data['contenu'])) {
            return $this->jsonResponse(['error' => 'Corps de requête invalide'], 400);
        }

        $id = $this->messageModel->create(
            (int) $data['id_expediteur'],
            (int) $data['id_destinataire'],
            (string) $data['contenu']
        );

        return $this->jsonResponse(['id_message' => $id], 201);
    }

    
    // GET /api/messages/{id}
     
    public function show(string $id): string
    {
        $message = $this->messageModel->findById($id);

        if (!$message) {
            return $this->jsonResponse(['error' => 'Message introuvable'], 404);
        }

        return $this->jsonResponse($this->messageToArray($message));
    }

    /**
     * GET /api/messages/entre/{id1}/{id2}
     * Conversation entre deux utilisateurs
     */

    public function entreUtilisateurs(string $id1, string $id2): string
    {
        $messages = $this->messageModel->findEntreUtilisateurs((int) $id1, (int) $id2);

        $messages = array_map([$this, 'messageToArray'], $messages);

        return $this->jsonResponse($messages);
    }

    /**
     * GET /api/messages/recus/{id}
     * Boîte de réception d'un utilisateur.
     */

    public function recus(string $id): string
    {
        $messages = $this->messageModel->findRecus((int) $id);

        $messages = array_map([$this, 'messageToArray'], $messages);

        return $this->jsonResponse($messages);
    }

    /**
     * PUT /api/messages/{id}/lu
     * Marque un message comme lu.
     */

    public function marquerCommeLu(string $id): string
    {
        $success = $this->messageModel->marquerCommeLu($id);

        if (!$success) {
            return $this->jsonResponse(['error' => 'Échec de la mise à jour'], 500);
        }

        return $this->jsonResponse(['message' => 'Message marqué comme lu']);
    }

    /**
     * DELETE /api/messages/{id}
     */

    public function delete(string $id): string
    {
        $success = $this->messageModel->delete($id);

        if (!$success) {
            return $this->jsonResponse(['error' => 'Échec de la suppression'], 500);
        }

        return $this->jsonResponse(['message' => 'Message supprimé']);
    }

    /**
     * Normalise un message MongoDB pour la réponse JSON.
     */
    
    private function messageToArray(array $message): array
    {
        return [
            '_id' => $message['_id'],
            'id_expediteur' => $message['id_expediteur'],
            'id_destinataire' => $message['id_destinataire'],
            'contenu' => $message['contenu'],
            'lu' => $message['lu'],
            'date_envoi' => $message['date_envoi'],
        ];
    }

    private function jsonResponse(mixed $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}