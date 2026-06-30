<?php

namespace Controllers;

use Models\NoteModel;
use Entity\Note;


class NoteController
{
    private NoteModel $noteModel;

    public function __construct()
    {
        $this->noteModel = new NoteModel();
    }

    /**
     * POST /api/notes
     * Le passager note un chauffeur sur un trajet précis.
     */
    
    public function create(): string
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['note'], $data['id_utilisateurs'], $data['id_trajet'], $data['id_auteur'])) {
            return $this->jsonResponse(['error' => 'Corps de requête invalide'], 400);
        }

        try {
            $note = new Note(
                (int) $data['note'],
                (int) $data['id_utilisateurs'],
                (int) $data['id_trajet'],
                (int) $data['id_auteur']
            );
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }

        try {
            $id = $this->noteModel->create($note);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 409);
        }

        if ($id === false) {
            return $this->jsonResponse(['error' => 'Échec de l\'enregistrement de la note'], 500);
        }

        return $this->jsonResponse(['id_note' => $id], 201);
    }

    private function jsonResponse(mixed $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}