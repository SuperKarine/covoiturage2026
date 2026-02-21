<?php

namespace App\Entity;

class Retour
{
    /**
     * @var int $id_retour     en auto incrémente
     */
    private int $id_retour;

    /**
     * @var string $ville_retour
     */
    private string $ville_retour;

    /**
     * @var integer $id_villes Clé étrangère id de la class villes
     */
    private int $id_villes;
    

    /**
     * Constructor
     */
    public function __construct(
        int $id_retour,
        string $ville_retour,
        int $id_villes

    )
    {
        $this->id_retour = $id_retour;
        $this->ville_retour = $ville_retour;
        $this->id_villes = $id_villes;
    }
    
    
    /**
     * Récupère l'identifiant de retour     id en auto incrémente
     *
     * @return id_retour
     */
    public function getIdRetour()
    {
        return $this->id_retour;
    }

    /**
     * Récupère la ville de retour
     *
     * @return ville_retour
     */
    public function getVilleRetour()
    {
        return $this->ville_retour;
    }

    /**
     * Modifie/Affecte  la ville de retour
     *
     * @param string $ville_retour
     * @return ville_retour
     */
    public function setVilleRetour($ville_retour)
    {
        $this->ville_retour = $ville_retour;

        return $this; 
    }

    /**
     * récupère l'id da la classe villes
     *
     * @return id_villes
     */
    public function getIdVilles()
    {
        return $this->id_villes;
    }

    
}