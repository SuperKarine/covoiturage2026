<?php

namespace App\Repository;

use App\Entity\Utilisateurs;
use PDO;
use DateTime;

class UtilisateursRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM utilisateurs WHERE id_utilisateurs = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            return $data;
        }
        
        return null;
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUtilisateur($userData)
{
    try {
        $sql = "INSERT INTO utilisateurs (
                    nom, prenom, pseudo, email, mot_de_passe, date_naissance, 
                    telephone, isEmploye, isPassager, isChauffeur, 
                    isPassagerChauffeur, credits, date_credit, debit, date_debit
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            $userData['nom'],
            $userData['prenom'],
            $userData['pseudo'],
            $userData['email'],
            $userData['mot_de_passe'],
            $userData['date_naissance'],
            $userData['telephone'],
            $userData['isEmploye'],
            $userData['isPassager'],
            $userData['isChauffeur'],
            $userData['isPassagerChauffeur'],
            $userData['credits'],
            $userData['date_credit'],
            $userData['debit'],
            $userData['date_debit']
        ]);

        return $success;
    } catch (\Exception $e) {
        error_log("Erreur creation utilisateur: " . $e->getMessage());
        return false;
    }
}
    
}