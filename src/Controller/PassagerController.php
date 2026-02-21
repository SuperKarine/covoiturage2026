<?php

namespace App\Controller;

use App\Repository\PassagersRepository;
use App\Repository\ChauffeursRepository;
use App\Repository\UtilisateursRepository;

class PassagerController extends Controller
{
    private PassagersRepository $passagersRepository;
    private ChauffeursRepository $chauffeursRepository;
    private UtilisateursRepository $utilisateursRepository;

    public function __construct()
    {
        $this->passagersRepository = new PassagersRepository();
        $this->chauffeursRepository = new ChauffeursRepository();
        $this->utilisateursRepository = new UtilisateursRepository();
    }

    /**
     * Affiche le tableau de bord passager
     */
    public function showDashboard(): void
    {
        AuthController::requireUserType(['passager', 'admin']);
        
        $passager = $this->passagersRepository->findById($_SESSION['user_id']);
        $trajetsDisponibles = $this->chauffeursRepository->getAllTrajetsDisponibles();
        
        $this->render('passager/dashboard', [
            'passager' => $passager,
            'trajetsDisponibles' => $trajetsDisponibles
        ]);
    }

    /**
     * Affiche les réservations en cours
     */
    public function showReservations(): void
    {
        AuthController::requireUserType(['passager', 'admin']);
        
        // Utiliser directement la méthode du repository si elle existe
        $reservations = $this->passagersRepository->getReservationsByPassager($_SESSION['user_id']);
        
        $this->render('passager/reservations', [
            'reservations' => $reservations
        ]);
    }

    /**
     * Affiche l'historique des trajets
     */
    public function showHistorique(): void
    {
        AuthController::requireUserType(['passager', 'admin']);
        
        // Utiliser directement la méthode du repository si elle existe
        $historique = $this->passagersRepository->getHistoriqueByPassager($_SESSION['user_id']);
        
        $this->render('passager/historique', [
            'historique' => $historique
        ]);
    }

    /**
     * Affiche le profil du passager
     */
    public function showProfil(): void
    {
        AuthController::requireUserType(['passager', 'admin']);
        
        $passager = $this->passagersRepository->findById($_SESSION['user_id']);
        $utilisateur = $this->utilisateursRepository->getUserById($_SESSION['user_id']);
        
        $this->render('passager/profil', [
            'passager' => $passager,
            'utilisateur' => $utilisateur
        ]);
    }

    /**
     * Crée une réservation
     */
    public function createReservation(): void
    {
        AuthController::requireUserType(['passager', 'admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /passager/dashboard?error=method');
            exit;
        }

        $trajetId = intval($_POST['trajet_id'] ?? 0);
        $nombrePlaces = intval($_POST['nombre_places'] ?? 1);

        if ($trajetId <= 0 || $nombrePlaces <= 0) {
            header('Location: /passager/dashboard?error=invalid_data');
            exit;
        }

        // Utiliser directement la méthode du repository
        $success = $this->passagersRepository->createReservation(
            $_SESSION['user_id'],
            $trajetId,
            $nombrePlaces
        );

        if ($success) {
            header('Location: /passager/reservations?success=reservation_created');
        } else {
            header('Location: /passager/dashboard?error=reservation_failed');
        }
        exit;
    }

    /**
     * Annule une réservation
     */
    public function cancelReservation(): void
    {
        AuthController::requireUserType(['passager', 'admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /passager/reservations?error=method');
            exit;
        }

        $reservationId = intval($_POST['reservation_id'] ?? 0);

        if ($reservationId <= 0) {
            header('Location: /passager/reservations?error=invalid_id');
            exit;
        }

        // Utiliser directement la méthode du repository
        $success = $this->passagersRepository->cancelReservation($reservationId, $_SESSION['user_id']);

        if ($success) {
            header('Location: /passager/reservations?success=reservation_cancelled');
        } else {
            header('Location: /passager/reservations?error=cancel_failed');
        }
        exit;
    }

    /**
     * Recharge les crédits
     */
    public function rechargerCredits(): void
    {
        AuthController::requireUserType(['passager', 'admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /passager/profil?error=method');
            exit;
        }

        $montant = intval($_POST['montant'] ?? 0);

        if ($montant <= 0) {
            header('Location: /passager/profil?error=invalid_amount');
            exit;
        }

        $success = $this->passagersRepository->rechargeCredits($_SESSION['user_id'], $montant);

        if ($success) {
            // Mettre à jour la session
            $passager = $this->passagersRepository->findById($_SESSION['user_id']);
            if ($passager) {
                $_SESSION['user_credits'] = $passager->getCreditRestant();
            }
            header('Location: /passager/profil?success=credits_recharged');
        } else {
            header('Location: /passager/profil?error=recharge_failed');
        }
        exit;
    }
}