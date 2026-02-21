<?php

namespace App\Entity;

use DateTime;

class Trajets
{
   
   /**
    * @var int $id_trajets              identifiant du trajet en auto incrément
    */
    private $id_trajets;

    /**
     * @var DateTime $date_heure_arrivee          Date et heure d'arrivée du trajet 
     */
    private $date_heure_arrivee;

    /**
     * @var DateTime $date_heure_depart          Date et heure de départ du trajet
     */
    private $date_heure_depart;

    /**
     * @var string $ville_depart           Ville du départ du trajet
     */
    private $ville_depart;

    /**
     * @var string $ville_arrivee            ville d'arrivée du trajet
     */
    private $ville_arrivee;

    /**
     * @var int $id_trajets_effectues       L'identifiant du trajets effectués pour le relier à la classe trajet
     */
    private $id_trajets_effectues;

    /**
     * @var int $num_trajet        L'identifiant de la classe trajet
     */
    private $num_trajet;
    

    /**
     * Constructor
     */
    public function __construct(
        int $id_trajets,
        DateTime $date_heure_arrivee,
        DateTime $date_heure_depart,
        string $ville_depart,
        string $ville_arrivee,
        int $id_trajets_effectues,
        int $num_trajet

    )
    {
        $this->id_trajets = $id_trajets;
        $this->date_heure_arrivee = $date_heure_arrivee;
        $this->date_heure_depart = $date_heure_depart;
        $this->ville_depart = $ville_depart;
        $this->ville_arrivee = $ville_arrivee;
        $this->id_trajets_effectues = $id_trajets_effectues;
        $this->num_trajet = $num_trajet;
        
    }

    /**
     * Récupère l'id du trajet     Identifiant du trajet en auto incrément
     *
     * @return id_trajets
     */
    public function getIdTrajets()
    {
        return $this->id_trajets;
    }

    
    /**
     * récupère la date et l'heure de l'arrivée
     *
     * @return 
     */
    public function getDateArrivee()
    {
        return $this->date_heure_arrivee;
    }


    /**
     * Modifie/Affecte  la date et l'heure d'arrivée
     *
     * @param DateTime $date_heure_arrivee
     * @return date_heure_arrivee
     */
    public function setDateArrivee($date_heure_arrivee)
    {
        $this->date_heure_arrivee = $date_heure_arrivee;

        return $this;
    }


    /**
     * récupère la date et l'heure du départ
     *
     * @return date_heure_depart
     */
    public function getDateDepart()
    {
        return $this->date_heure_depart;
    }


    /**
     * Modifie/Affecte  la date et l'heure du départ
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
     * Récupère la ville du départ
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
     * Récupère la ville d'arrivée
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
     * Récupère l'id des trajets effectués
     *
     * @return id_trajets_effectues
     */
    public function getIdTrajetsEffectues()
    {
        return $this->id_trajets_effectues;
    }


    /**
     * récupère l'id du trajet qui est sous le nom de num_trajet
     *
     * @return num_trajet
     */
    public function getNumTrajet()
    {
        return $this->num_trajet;
    }

    
}