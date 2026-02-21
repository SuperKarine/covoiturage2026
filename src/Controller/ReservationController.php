<?php

namespace App\Controller;

use App\Repository\ReserverTrajetsRepository;
use App\Repository\UtilisateursRepository;

class ReservationController extends Controller
{
    public function reserverTrajet(): void
    {
        // Je vérifie si l'ID du trajet est présent dans l'URL
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $this->redirect('/liste_trajets?error=trajet_non_trouve');
            return;
        }

        $numTrajet = (int)$_GET['id'];
        
        // Je récupère les informations du trajet
        $reservationRepository = new ReserverTrajetsRepository();
        $trajet = $reservationRepository->getTrajetById($numTrajet);
        
        if (!$trajet) {
            $this->redirect('/liste_trajets?error=trajet_non_trouve');
            return;
        }

        // Je vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateurs'])) {
            $this->redirect('/connexion?error=connectez_vous');
            return;
        }

        // Je récupère les informations de l'utilisateur connecté
        $utilisateursRepository = new UtilisateursRepository();
        $user = $utilisateursRepository->getUserById($_SESSION['id_utilisateurs']);

        if (!$user) {
            $this->redirect('/connexion?error=utilisateur_non_trouve');
            return;
        }

        // Je passe les données à la vue
        $this->render('reservation/reserver_trajet', [
            'num_trajet' => $trajet->getNumTrajet(),
            'ville_depart' => $trajet->getVilleDepart(),
            'ville_arrivee' => $trajet->getVilleArrivee(),
            'date_heure_depart' => $trajet->getDateHeureDepart()->format('d/m/Y H:i'),
            'nbr_place_trajet' => $trajet->getNbrPlaceRestantes(), 
            'pseudo_chauffeur' => $trajet->getPseudoChauffeur(),
            'prenom' => $user['prenom'],
            'nom' => $user['nom'],
            'email' => $user['email']
        ]);
    }

    // Méthode pour traiter la réservation (POST)
    public function traiterReservation(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données du formulaire
            $numTrajet = (int)$_POST['num_trajet'];
            $nbrPlaces = (int)$_POST['nbr_places'];
            $message = $_POST['message'] ?? '';
            
            // Je vérifie que l'utilisateur est connecté
            if (!isset($_SESSION['id_utilisateurs'])) {
                $this->redirect('/connexion?error=connectez_vous');
                return;
            }
            
            // Pour enregistrer la réservation
            $reservationRepository = new ReserverTrajetsRepository();
            $success = $reservationRepository->createReservation(
                $numTrajet, 
                $_SESSION['id_utilisateurs'], 
                $nbrPlaces, 
                $message
            );
            
            if ($success) {
                $this->redirect('/mes_reservations?success=reservation_ok');
            } else {
                $this->redirect('/reserver_trajet?id=' . $numTrajet . '&error=reservation_erreur');
            }
        } else {
            // Pour empêcher l'accès à cette URL en GET
            $this->redirect('/liste_trajets');
        }
    }

    // Méthode pour afficher les réservations de l'utilisateur
    public function mesReservations(): void
    {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateurs'])) {
            $this->redirect('/connexion?error=connectez_vous');
            return;
        }

        $reservationRepository = new ReserverTrajetsRepository();
        $reservations = $reservationRepository->getReservationsByUser($_SESSION['id_utilisateurs']);

        $this->render('reservation/mes_reservations', [
            'reservations' => $reservations
        ]);
    }

    // Méthode redirect 
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    
}