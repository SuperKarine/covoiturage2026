<?php

namespace Controllers;

use Models\DemandeChauffeurModel;
use Models\UtilisateursModel;
use Services\Mailer;
use Entity\DemandeChauffeur;

class DemandeChauffeurController
{
    private DemandeChauffeurModel $demandeModel;
    private UtilisateursModel $utilisateursModel;

    public function __construct()
    {
        $this->demandeModel = new DemandeChauffeurModel();
        $this->utilisateursModel = new UtilisateursModel();
    }

    /**
     * POST /api/demandes-chauffeur
     * Le passager soumet une demande pour devenir chauffeur
     */

    public function create(): string
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['id_utilisateurs'])) {
            return $this->jsonResponse(['error' => 'Corps de requête invalide'], 400);
        }

        $idUtilisateur = (int) $data['id_utilisateurs'];

        $id = $this->demandeModel->create($idUtilisateur);

        if ($id === false) {
            return $this->jsonResponse(['error' => 'Échec de la création de la demande'], 500);
        }

        $this->envoyerMailDemandeDocuments($idUtilisateur);

        return $this->jsonResponse(['id_demande' => $id], 201);
    }

    // GET /api/demandes-chauffeur/{id}

    public function show(string $id): string
    {
        $demande = $this->demandeModel->findById((int) $id);

        if (!$demande) {
            return $this->jsonResponse(['error' => 'Demande introuvable'], 404);
        }

        return $this->jsonResponse($this->demandeToArray($demande));
    }

    /**
     * GET /api/demandes-chauffeur
     * Liste des demandes en attente
     */

    public function index(): string
    {
        $demandes = $this->demandeModel->findEnAttente();

        return $this->jsonResponse($demandes);
    }

    // POST /api/demandes-chauffeur/{id}/accepter

    public function accepter(string $id): string
    {
        $demande = $this->demandeModel->findById((int) $id);

        if (!$demande) {
            return $this->jsonResponse(['error' => 'Demande introuvable'], 404);
        }

        try {
            $demande->accepter();
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }

        $this->demandeModel->save($demande);
        $this->envoyerMailDecision($demande, true);

        return $this->jsonResponse(['message' => 'Demande acceptée, utilisateur passé en chauffeur']);
    }

    // POST /api/demandes-chauffeur/{id}/refuser

    public function refuser(string $id): string
    {
        $demande = $this->demandeModel->findById((int) $id);

        if (!$demande) {
            return $this->jsonResponse(['error' => 'Demande introuvable'], 404);
        }

        try {
            $demande->refuser();
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }

        $this->demandeModel->save($demande);
        $this->envoyerMailDecision($demande, false);

        return $this->jsonResponse(['message' => 'Demande refusée']);
    }

    private function demandeToArray(DemandeChauffeur $demande): array
    {
        return [
            'id_demande' => $demande->getIdDemande(),
            'id_utilisateurs' => $demande->getIdUtilisateurs(),
            'statut' => $demande->getStatut()->value,
            'date_demande' => $demande->getDateDemande()->format('Y-m-d H:i:s'),
            'date_traitement' => $demande->getDateTraitement()?->format('Y-m-d H:i:s'),
        ];
    }

    private function envoyerMailDemandeDocuments(int $idUtilisateur): void
    {
        $user = $this->utilisateursModel->findById($idUtilisateur);

        if ($user) {
            $mailer = new Mailer();
            $mailer->sendDemandeDocuments($user['mail'], $user['prenom'] . ' ' . $user['nom']);
        }
    }

    private function envoyerMailDecision(DemandeChauffeur $demande, bool $accepte): void
    {
        $user = $this->utilisateursModel->findById($demande->getIdUtilisateurs());

        if ($user) {
            $mailer = new Mailer();
            $mailer->sendDecisionChauffeur($user['mail'], $user['prenom'] . ' ' . $user['nom'], $accepte);
        }
    }

    private function jsonResponse(mixed $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
    
}