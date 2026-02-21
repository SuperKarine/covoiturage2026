<?php

namespace App\Repository;

use App\Entity\ProposeTrajetChauffeurs;
use PDO;
use DateTime;


class ProposeTrajetChauffeursRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM propose_trajet_chauffeurs");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        $trajetsChauffeurs = [];
        foreach ($data as $row) {
            try {
                // Combinaison date + heure pour créer des DateTime complets
                $dateTimeArrivee = DateTime::createFromFormat(
                    'Y-m-d H:i:s', 
                    $row['date_arrivee'] . ' ' . $row['heure_arrivee']
                );

                $dateTimeDepart = DateTime::createFromFormat(
                    'Y-m-d H:i:s', 
                    $row['date_depart'] . ' ' . $row['heure_depart']
                );
                
                
                // Je vérifie que la création a réussi
                if ($dateTimeDepart === false || $dateTimeArrivee === false) {
                    error_log("Erreur de conversion datetime pour le trajet {$row['num_trajet']}");
                    continue;
                }

                $trajetsChauffeurs[] = new ProposeTrajetChauffeurs(
                    (int) $row['num_trajet'],
                    $dateTimeArrivee,
                    $dateTimeDepart,    
                    $row['ville_depart'],
                    $row['ville_arrivee'],
                    $row['pseudo_chauffeur'],
                    $row['marque'],
                    $row['modele'],
                    (int) $row['nbr_place_restantes'],
                    (int) $row['nbr_place_trajet'],
                    (int) $row['prix_personne'],
                    (float) $row['temps_trajets'],
                    $row['information_sup'],
                    (bool) $row['voyage_ecologique'] 
                );
            } catch (\Exception $e) {
                error_log("Erreur création trajet chauffeur {$row['num_trajet']}: " . $e->getMessage());
            }
        }

        return $trajetsChauffeurs;
    }
}


          



   
    

    
        



