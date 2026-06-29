<?php

namespace Controllers;

use Models\TrajetModel;


class TrajetController
{
    private TrajetModel $trajetModel;

    public function __construct()
    {
        $this->trajetModel = new TrajetModel();
    }

    /**
     * GET /api/trajets
     * Recherche de trajets avec filtres optionnels 
     */

    public function search(): string
    {
        $filters = [];

        if (!empty($_GET['ville_depart'])) {
            $filters['ville_depart'] = $_GET['ville_depart'];
        }
        if (!empty($_GET['ville_arrivee'])) {
            $filters['ville_arrivee'] = $_GET['ville_arrivee'];
        }
        if (!empty($_GET['date_depart'])) {
            $filters['date_depart'] = $_GET['date_depart'];
        }
        if (isset($_GET['places_min'])) {
            $filters['places_min'] = (int) $_GET['places_min'];
        }
        if (isset($_GET['fumeur'])) {
            $filters['fumeur'] = (bool) (int) $_GET['fumeur'];
        }
        if (isset($_GET['animaux'])) {
            $filters['animaux'] = (bool) (int) $_GET['animaux'];
        }
        if (isset($_GET['prix_max'])) {
            $filters['prix_max'] = (float) $_GET['prix_max'];
        }

        $trajets = $this->trajetModel->search($filters);

        return $this->jsonResponse($trajets);
    }

    
    // GET /api/trajets/{id}
     
    public function show(string $id): string
    {
        $trajet = $this->trajetModel->findById((int) $id);

        if (!$trajet) {
            return $this->jsonResponse(['error' => 'Trajet introuvable'], 404);
        }

        return $this->jsonResponse($trajet);
    }

    /**
    * GET /trajets
    * Page HTML de recherche de trajets (formulaire + résultats via fetch JS).
    */

    public function index(): string
    {
        ob_start();

        require __DIR__ . '/../../views/trajets/index.php';

        $content = ob_get_clean();

        ob_start();

        require __DIR__ . '/../../views/layouts/main.php';

        return ob_get_clean();
    }

    /**
     * POST /api/trajets
     * Corps de la requête en JSON.
     */

    public function create(): string
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            return $this->jsonResponse(['error' => 'Corps de requête invalide'], 400);
        }

        $id = $this->trajetModel->create($data);

        if ($id === false) {
            return $this->jsonResponse(['error' => 'Échec de la création du trajet'], 500);
        }

        return $this->jsonResponse(['id_trajet' => $id], 201);
    }

    
    // PUT /api/trajets/{id}
     

    public function update(string $id): string
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            return $this->jsonResponse(['error' => 'Corps de requête invalide'], 400);
        }

        $success = $this->trajetModel->update((int) $id, $data);

        if (!$success) {
            return $this->jsonResponse(['error' => 'Échec de la mise à jour'], 500);
        }

        return $this->jsonResponse(['message' => 'Trajet mis à jour']);
    }

    
    // DELETE /api/trajets/{id}
     
    public function delete(string $id): string
    {
        $success = $this->trajetModel->delete((int) $id);

        if (!$success) {
            return $this->jsonResponse(['error' => 'Échec de la suppression'], 500);
        }

        return $this->jsonResponse(['message' => 'Trajet supprimé']);
    }

    
    // Génère une réponse JSON avec le bon code HTTP et le bon Content-Type.
     
    private function jsonResponse(mixed $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}