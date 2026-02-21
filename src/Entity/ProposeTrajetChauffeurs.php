<?php

namespace App\Entity;

use DateTime;


class ProposeTrajetChauffeurs
{
    /**
     * @var int $num_trajet   identifiant de la table  Propose_trajet_chauffeurs en auto increment
     */
    private int $num_trajet;

    /**
     * @var DateTime $date_heure_arrivee     La date et l'heure d'arrivée
     */
    private DateTime $date_heure_arrivee;

    /**
     * @var DateTime $date_heure_depart     La date et l'heure de départ
     */
    private DateTime $date_heure_depart;

    /**
     * @var string $ville_depart      La ville de départ
     */
    private string $ville_depart;

    /**
     * @var string $ville_arrivee      La ville d'arrivée
     */
    private string $ville_arrivee;

    /**
     * @var string $pseudo_chauffeur    Le pseudo du chauffeur
     */
    private string $pseudo_chauffeur;

    /**
     * @var string $marque               La marque de la voiture
     */
    private string $marque;

    /**
     * @var string $modele                Le modèle de la voiture
     */
    private string $modele;

    /**
     * @var integer $nbr_place_restantes    Nombre de places restantes disponible dans le véhicule
     */
    private int $nbr_place_restantes;

    /**
     * @var integer $nbr_place_trajet        Nombre de places pour le trajet
     */
    private int $nbr_place_trajet;

    /**
     * @var integer $prix_personne           Prix du trajet par personne
     */
    private int $prix_personne;

    /**
     * @var float $temps_trajets             Le temps du trajet
     * 
     */
    private float $temps_trajets;

    /**
     * @var string $information_sup           Les éventuelles informations supplémentaires du chauffeur
     */
    private string $information_sup;

    /**
     * @var bool $voyage_ecologique           Retourne un bool 
     */
    private bool $voyage_ecologique;


    /**
     * Propose_trajet_chauffeurs
     * Méthode magique qui est appelé automatiquement lors de l'instanciation de Propose_trajet_chauffeurs
     */
    public function __construct(
        int $num_trajet,
        DateTime $date_heure_arrivee,
        DateTime $date_heure_depart,
        string $ville_depart,
        string $ville_arrivee,
        string $pseudo_chauffeur,
        string $marque,
        string $modele,
        int $nbr_place_restantes,
        int $nbr_place_trajet,
        int $prix_personne,
        float $temps_trajets,
        string $information_sup,
        bool $voyage_ecologique

    )
    {
         $this->num_trajet = $num_trajet;
         $this->date_heure_arrivee = $date_heure_arrivee;
         $this->date_heure_depart = $date_heure_depart;
         $this->ville_depart = $ville_depart;
         $this->ville_arrivee = $ville_arrivee;
         $this->pseudo_chauffeur = $pseudo_chauffeur;
         $this->marque = $marque;
         $this->modele = $modele;
         $this->nbr_place_restantes = $nbr_place_restantes;
         $this->nbr_place_trajet = $nbr_place_trajet;
         $this->prix_personne = $prix_personne;
         $this->temps_trajets = $temps_trajets;
         $this->information_sup = $information_sup;
         $this->voyage_ecologique = $voyage_ecologique;

    }



    /**
     * Récupère l'id de propose_trajet_chauffeurs       identifiant en auto incrémente de propose_trajet_chauffeurs
     *
     * @return num_trajet
     */
    public function getNumTrajet()
    {
        return $this->num_trajet;
    }

    /**
     * Récupère la date et l'heure d'arrivée
     *
     * @return date_heure_arrivee
     */
    public function getDateHeureArrivee()
    {
        return $this->date_heure_arrivee;
    }

    /**
     * Modifie la date et l'heure d'arrivée
     *
     * @param DateTime $date_heure_arrivee
     * @return date_heure_arrivee
     */
    public function setDateHeureArrivee($date_heure_arrivee)
    {
        $this->date_heure_arrivee = $date_heure_arrivee;

        return $this;
    }

    /**
     * Récupère la date et l'heure de départ
     *
     * @return date_heure_depart
     */
    public function getDateHeureDepart()
    {
        return $this->date_heure_depart;
    }

    /**
     * Modifie la date et l'heure de départ
     *
     * @param DateTime $date_heure_depart
     * @return date_heure_depart
     */
    public function setDateHeureDepart($date_heure_depart)
    {
        $this->date_heure_depart = $date_heure_depart;

        return $this;
    }

    /**
     * Récupère la ville de départ
     *
     * @return ville_depart
     */
    public function getVilleDepart()
    {
        return $this->ville_depart;
    }

    /**
     * Modifie la ville de départ
     *
     * @param string $ville_depart
     * @return ville_depart
     */
    public function setVilleDepart($ville_depart)
    {
        $this->ville_depart = $ville_depart;

        return $this;
    }

    /**
     * Récupère la ville d'arrivée
     *
     * @return ville_arrivee
     */
    public function getVilleArrivee()
    {
        return $this->ville_arrivee;
    }

    /**
     * Modifie la ville d'arrivée
     *
     * @param string $ville_arrivee
     * @return ville_arrivee
     */
    public function setVilleArrivee($ville_arrivee)
    {
        $this->ville_arrivee = $ville_arrivee;

        return $this;
    }

    /**
     * Récupère le pseudo du chauffeur
     *
     * @return pseudo_chauffeur
     */
    public function getPseudoChauffeur()
    {
        return $this->pseudo_chauffeur;
    }

    /**
     * Modifie le pseudo du chauffeur
     *
     * @param string $pseudo_chauffeur
     * @return pseudo_chauffeur
     */
    public function setPseudoChauffeur($pseudo_chauffeur)
    {
        $this->pseudo_chauffeur= $pseudo_chauffeur;

        return $this;
    }

    /**
     * Récupère la marque de la voiture
     *
     * @return marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Modifie la marque de la voiture
     *
     * @param string $marque
     * @return marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Récupère le modèle de la voiture
     *
     * @return modele
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Modifie le modèle
     *
     * @param string $modele
     * @return modele
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Récupère le nombre de place restantes
     *
     * @return nbr_place_restantes
     */
    public function getNbrPlaceRestantes()
    {
        return $this->nbr_place_restantes;
    }

    /**
     * Modifie/Affecte  le nombre de places restantes
     *
     * @param int $nbr_place_restantes
     * @return nbr_place_restantes
     */
    public function setNbrPlaceRestantes($nbr_place_restantes)
    {
        $this->nbr_place_restantes = $nbr_place_restantes;

        return $this;
    }

    /**
     * Récupère le nombre de place de trajet
     *
     * @return nbr_place_trajet
     */
    public function getNbrPlaceTrajet()
    {
        return $this->nbr_place_trajet;
    }

    /**
     * Modifie/Affecte  le nombre de place trajet
     *
     * @param int $nbr_place_trajet
     * @return nbr_place_trajet
     */
    public function setNbrPlaceTrajet($nbr_place_trajet)
    {
        $this->nbr_place_trajet = $nbr_place_trajet;

        return $this;
    }

    /**
     * Récupère le prix du trajet par personne
     *
     * @return prix_personne
     */
    public function getPrixPersonne()
    {
        return $this->prix_personne;
    }

    /**
     * Modifie/Affecte  le prix du trajet par personne
     *
     * @param int $prix_personne
     * @return prix_personne
     */
    public function setPrixPersonne($prix_personne)
    {
        $this->prix_personne = $prix_personne;

        return $this;
    }

    /**
     * Récupère le temps de trajet
     *
     * @return temps_trajets
     */
    public function getTempsTrajets()
    {
        return $this->temps_trajets;
    }

    /**
     * Modifie/Affecte le temps du trajet
     *
     * @param float $temps_trajets
     * @return temps_trajets
     */
    public function setTempsTrajets($temps_trajets)
    {
        $this->temps_trajets = $temps_trajets;

        return $this;
    }

    /**
     * Récupère les informations supplémentaires
     *
     * @return information_sup
     */
    public function getInformationSup()
    {
        return $this->information_sup;
    }

    /**
     * Modifie/Affecte  les informations supplémentaires
     *
     * @param string $information_sup
     * @return information_sup
     */
    public function setInformationSup($information_sup)
    {
        $this->information_sup = $information_sup;

        return $this;
    }

    /**
     * Récupère les voyages ecologique
     *
     * @return voyage_ecologique
     */
    public function getVoyageEcologique()
    {
        return $this->voyage_ecologique;
    }

    /**
     * Modifie/Affecte  les voyages ecologique
     *
     * @param bool $voyage_ecologique
     * @return voyage_ecologique
     */
    public function setVoyageEcologique($voyage_ecologique)
    {
        $this->voyage_ecologique = $voyage_ecologique;

        return $this;
    }

   
    
}