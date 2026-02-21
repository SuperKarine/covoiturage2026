<?php

namespace App\Entity;

use DateTime;

class ProposeTrajetPassagers
{
    /**
     * @var int $id_propose_trajet_passagers     L'identifiant de propose_trajet_passagers en auto incrémente
     */
    private int $id_propose_trajet_passagers;

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
     * @var integer $nombre_passagers
     */
    private int $nombre_passagers;

    /**
     * @var boolean $fumeur
     */
    private bool $fumeur;

    /**
     * @var boolean $animal
     */
    private bool $animal;
    

    public function __construct(
        int $id_propose_trajet_passagers,
        DateTime $date_heure_arrivee,
        DateTime $date_heure_depart,
        string $ville_depart,
        string $ville_arrivee,
        int $nombre_passagers,
        bool $fumeur,
        bool $animal

    )
    {
        $this->id_propose_trajet_passagers = $id_propose_trajet_passagers;
        $this->date_heure_arrivee = $date_heure_arrivee;
        $this->date_heure_depart = $date_heure_depart;
        $this->ville_depart = $ville_depart;
        $this->ville_arrivee = $ville_arrivee;
        $this->nombre_passagers = $nombre_passagers;
        $this->fumeur = $fumeur;
        $this->animal= $animal;

    }

    /**
     * Récupère l'id de propose_trajet_passagers        en auto incrémente
     *
     * @return id_propose_trajet_passagers
     */
    public function getIdProposeTrajetPassagers()
    {
        return $this->id_propose_trajet_passagers;
    }

    /**
     * récupère la date et l'heure de l'arrivée
     *
     * @return date_heure_arrivee
     */
    public function getDateHeureArrivee()
    {
        return $this->date_heure_arrivee;
    }

    /**
     * Modifie/Affecte  la date et l'heure de l'arrivée
     *
     * @param Datetime $date_heure_arrivee
     * @return date_heure_arrivee
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
    public function setDateDepart($date_heure_depart)
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
     * Modifie/Affecte  la ville arrivée
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
     * Récupère le nombre de passagers
     *
     * @return nombre_passagers
     */
    public function getNombrePassagers()
    {
        return $this->nombre_passagers;
    }

    /**
     * Modifie/Affecte  le nombre de passagers
     *
     * @param int $nombre_passagers
     * @return nombre_passagers
     */
    public function setNombrePassagers($nombre_passagers)
    {
        $this->nombre_passagers= $nombre_passagers;

        return $this;
    }

    /**
     * Récupère les chauffeurs qui acceptent les fumeurs
     *
     * @return fumeur
     */
    public function getFumeur()
    {
        return $this->fumeur;
    }

    /**
     * Modifie/Affecte  les chauffeurs qui acceptent les fumeurs
     *
     * @param bool $fumeur
     * @return fumeur
     */
    public function setFumeur($fumeur)
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    /**
     * Récupère les chauffeurs qui acceptent les animaux
     *
     * @return animal
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * Modifie/Affecte  la liste des chauffeurs qui acceptent les animaux
     *
     * @param bool $animal
     * @return animal
     */
    public function setAnimal($animal)
    {
        $this->animal = $animal;

        return $this;
    }

    
}