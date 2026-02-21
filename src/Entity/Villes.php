<?php

namespace App\Entity;

class Villes
{
    /**
     * @var int $id_villes     identifiant en auto incrémente
     */
    private int $id_villes;

    /**
     * @var string $nom_ville
     */
    private string $nom_ville;
    

    /**
     * Constructor
     */
    public function __construct(
        int $id_villes,
        string $nom_ville
    )
    {
        $this->id_villes =$id_villes;
        $this->nom_ville =$nom_ville; 
    }

    
    /**
     * Récupère l'identifiant de la ville
     *
     * @return id_villes
     */
    public function getIdVilles()
    {
        return $this->id_villes;
    }

    /**
     * Récupère le nom de la ville
     *
     * @return nom_ville
     */
    public function getNomVille()
    {
        return $this->nom_ville;
    }

    /**
     * Modifie/Affecte  le nom de la ville
     *
     * @param string $nom_ville
     * @return nom_ville
     */
    public function setNomVille($nom_ville)
    {
        $this->nom_ville = $nom_ville;

        return $this;
    }

    
}