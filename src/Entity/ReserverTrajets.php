<?php

namespace App\Entity;

use DateTime;


class ReserverTrajets
{
    /**
     * @var integer $id_reserver_trajet  identifiant de reserver_trajet en auto incrémente
     */
    private int $id_reserver_trajet;

    /**
     * @var integer $num_trajet_reserve
     */
    private int $num_trajet_reserve;

    /**
     * @var DateTime $date_heure_arrivee
     */
    private DateTime $date_heure_arrivee;

    /**
     * @var DateTime $date_heure_depart
     */
    private DateTime $date_heure_depart;

    /**
     * @var string $ville_depart
     */
    private string $ville_depart;

    /**
     * @var string $ville_arrivee
     */
    private string $ville_arrivee;

    /**
     * @var string $etat_validation  return une enum de en attente, valide, refusé et par défaut en attente
     */
    private string $etat_validation;
    

    public function __construct(
        int $id_reserver_trajet,
        int $num_trajet_reserve,
        DateTime $date_heure_arrivee,
        DateTime $date_heure_depart,
        string $ville_depart,
        string $ville_arrivee


    )
    {
        $this->id_reserver_trajet = $id_reserver_trajet;
        $this->num_trajet_reserve = $num_trajet_reserve;
        $this->date_heure_arrivee = $date_heure_arrivee;
        $this->date_heure_depart = $date_heure_depart;
        $this->ville_depart = $ville_depart;
        $this->ville_arrivee = $ville_arrivee;
        
    }
    
    
    /**
     * Récupère l'id de  reserver_trajet      identifiant en auto incrémente
     *
     * @return id_reserver_trajet
     */
    public function getIdReserverTrajet()
    {
        return $this->id_reserver_trajet;
    }

    /**
     * Récupère la date et l'heure d'arrivée
     *
     * @return date_heure_arrivee
     */
    public function getDateArrivee()
    {
        return $this->date_heure_arrivee;
    }

    /**
     * Modifie/Affecte  la date et l'heure d'arrivée
     *
     * @param DateTime $date_heure_arrivee
     * @return date_arrivee
     */
    public function setDateArrivee($date_heure_arrivee)
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
     * Modifie/Affecte  la date et l'heure de départ
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
     * Modifie/Affecte  la ville de départ
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
     * Récupère la ville arrivée
     *
     * @return ville_arrivee
     */
    public function getVilleArrivee()
    {
        return $this->ville_arrivee;
    }

    /**
     * Modifie/Affecte  la ville d'arrivée
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
     * Récupère le numéro de trajet des trajets réservés
     *
     * @return num_trajet_reserve
     */
    public function getNumTrajetReserve()
    {
        return $this->num_trajet_reserve;
    }

    /**
     * Modifie/Affecte  le numéro de trajet des trajets réservés
     *
     * @param int $num_trajet_reserve
     * @return num_trajet_reserve
     */
    public function setNumTrajetReserve($num_trajet_reserve)
    {
        $this->num_trajet_reserve= $num_trajet_reserve;

        return $this;
    }

    /**
     * Récupère l'état de validation 
     *
     * @return etat_validation
     */
    public function getEtatValidation()
    {
        return $this->etat_validation;
    }

    /**
     * Modifie/Affecte  l'état de validation
     *
     * @param string $etat_validation
     * @return etat_validation
     */
    public function setEtatValidation($etat_validation)
    {
        $this->etat_validation = $etat_validation;

        return $this;
    }

    
}