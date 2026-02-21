<?php

namespace App\Controller;

class AuthController extends Controller
{
    /**
     * Vérifie si l'utilisateur a un des types spécifiés
     * Redirige vers la page de connexion si non authentifié ou mauvais type
     */
    public static function requireUserType(array $requiredTypes): void
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            header('Location: /login?error=not_logged_in');
            exit;
        }

        // Vérifier si le type d'utilisateur est autorisé
        $userType = $_SESSION['user_type'];
        
        if (!in_array($userType, $requiredTypes)) {
            header('Location: /unauthorized?error=wrong_user_type');
            exit;
        }
    }

    /**
     * Vérifie si l'utilisateur est administrateur
     */
    public static function isAdmin(): bool
    {
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est connecté (sans vérifier le type)
     */
    public static function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=not_logged_in');
            exit;
        }
    }

    /**
     * Récupère l'ID de l'utilisateur connecté
     */
    public static function getCurrentUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Récupère le type de l'utilisateur connecté
     */
    public static function getCurrentUserType(): ?string
    {
        return $_SESSION['user_type'] ?? null;
    }
}