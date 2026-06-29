<?php

namespace Controllers;

use Models\ReservationModel;


class ReservationController
{
    private ReservationModel $reservationModel;

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
    }

    /**
     * POST /api/reservations
     * Le passager crée une nouvelle réservation (statut EN_ATTENTE).
     */

    public function create(): string
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['id_trajet'], $data['id_utilisateurs'], $data['nombre_places'])) {
            return $this->jsonResponse(['error' => 'Corps de requête invalide'], 400);
        }

        $id = $this->reservationModel->create(
            (int) $data['id_trajet'],
            (int) $data['id_utilisateurs'],
            (int) $data['nombre_places']
        );

        if ($id === false) {
            return $this->jsonResponse(['error' => 'Échec de la création de la réservation'], 500);
        }

        return $this->jsonResponse(['id_reservation' => $id], 201);
    }

    // GET /api/reservations/{id}
     
    public function show(string $id): string
    {
        $reservation = $this->reservationModel->findById((int) $id);

        if (!$reservation) {
            return $this->jsonResponse(['error' => 'Réservation introuvable'], 404);
        }

        return $this->jsonResponse($this->reservationToArray($reservation));
    }

    // POST /api/reservations/{id}/confirmer
     
    public function confirmer(string $id): string
    {
        $reservation = $this->reservationModel->findById((int) $id);

        if (!$reservation) {
            return $this->jsonResponse(['error' => 'Réservation introuvable'], 404);
        }

        $comptePassager = $reservation->getPassager()->getCompte();
        $compteChauffeur = $reservation->getTrajet()->getChauffeur()->getCompte();

        try {
            $reservation->confirmer($comptePassager, $compteChauffeur);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }

        $this->reservationModel->save($reservation, $comptePassager, $compteChauffeur);

        return $this->jsonResponse(['message' => 'Réservation confirmée']);
    }

    // POST /api/reservations/{id}/annuler
     
    public function annuler(string $id): string
    {
        $reservation = $this->reservationModel->findById((int) $id);

        if (!$reservation) {
            return $this->jsonResponse(['error' => 'Réservation introuvable'], 404);
        }

        $comptePassager = $reservation->getPassager()->getCompte();
        $compteChauffeur = $reservation->getTrajet()->getChauffeur()->getCompte();

        try {
            $reservation->annuler($comptePassager, $compteChauffeur);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }

        $this->reservationModel->save($reservation, $comptePassager, $compteChauffeur);

        return $this->jsonResponse(['message' => 'Réservation annulée']);
    }

    
    // POST /api/reservations/{id}/refuser
     
    public function refuser(string $id): string
    {
        $reservation = $this->reservationModel->findById((int) $id);

        if (!$reservation) {
            return $this->jsonResponse(['error' => 'Réservation introuvable'], 404);
        }

        try {
            $reservation->refuser();
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 422);
        }

        // refuser() ne touche ni aux comptes ni aux places : on ne sauvegarde que le statut.

        $comptePassager = $reservation->getPassager()->getCompte();
        $compteChauffeur = $reservation->getTrajet()->getChauffeur()->getCompte();
        $this->reservationModel->save($reservation, $comptePassager, $compteChauffeur);

        return $this->jsonResponse(['message' => 'Réservation refusée']);
    }

    
    // Transforme un objet Reservation en tableau simple pour la réponse JSON.
     
    private function reservationToArray($reservation): array
    {
        return [
            'id_reservation' => $reservation->getIdReservation(),
            'statut' => $reservation->getStatut()->value,
            'nombre_places' => $reservation->getNombrePlaces(),
            'trajet' => [
                'id_trajet' => $reservation->getTrajet()->getIdTrajet(),
                'prix' => $reservation->getTrajet()->getPrix(),
                'places_disponibles' => $reservation->getTrajet()->getPlacesDisponibles(),
            ],
            'passager' => [
                'nom' => $reservation->getPassager()->getNom(),
                'prenom' => $reservation->getPassager()->getPrenom(),
            ],
        ];
    }

    private function jsonResponse(mixed $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}