<?php

namespace App\Entity;

use DateTime;

class TrajetsEffectues
{
    /**
     * @var int   $id_trajets_effectues    l'identifiant en auto incrément des trajets effectuées
     */
    private $id_trajets_effectues;

    /**
     * @var string  $pseudo_chauffeur     le pseudo du chauffeur
     */
    private $pseudo_chauffeur;

    /**
     * @var string   $email_chauffeur    L'email du chauffeur
     */
    private $email_chauffeur;

    /**
     * @var float     $note_chauffeur   Note du chauffeur
     */
    private $note_chauffeur;

    /**
     * @var DateTime       $date_note_chauffeur     La date de la note du chauffeur
     */
    private $date_note_chauffeur;

    /**
     * @var string      $ville_depart         La ville du départ
     */
    private $ville_depart;

    /**
     * @var string       $ville_arrivee         La ville de l'arrivée
     */
    private $ville_arrivee;

    /**
     * @var string   $avis_trajet_passagers         L'avis des passagers sur les trajets effectués
     */
    private $avis_trajet_passagers;

    /**
     * @var DateTime    $date_avis_trajet_passagers          la date à laquelle les passagers ont laissés l'avis
     */
    private $date_avis_trajet_passagers;

    /**
     * @var int      $prix_personne           Le prix par personne du trajet
     */
    private $prix_personne;

    /**
     * @var bool   $voyage_ecologique       Est-ce que le voyage est écologique
     */
    private $voyage_ecologique;

    /**
     * @var DateTime          $date_trajet         La date du trajet
     */
    private $date_trajet;

    /**
     * @var float       $total_trajet      Le total des trajets
     */
    private $total_trajet;
    

    /**
     * Trajets_effectues constructor.
     * Méthode magique qui est appelé automatiquement lors de l'instanciation de Trajets_effectues
     */
    public function __construct(
        int $id_trajets_effectues,
        string $pseudo_chauffeur,
        string $email_chauffeur,
        float $note_chauffeur,
        DateTime $date_note_chauffeur,
        string $ville_depart,
        string $ville_arrivee,
        string $avis_trajet_passagers,
        DateTime $date_avis_trajet_passagers,
        int $prix_personne,
        bool $voyage_ecologique,
        DateTime $date_trajet,
        float $total_trajet


    )
    {
         $this->id_trajets_effectues = $id_trajets_effectues;
         $this->pseudo_chauffeur = $pseudo_chauffeur;
         $this->email_chauffeur = $email_chauffeur;
         $this->note_chauffeur = $note_chauffeur;
         $this->date_note_chauffeur = $date_note_chauffeur;
         $this->ville_depart = $ville_depart;
         $this->ville_arrivee = $ville_arrivee;
         $this->avis_trajet_passagers = $avis_trajet_passagers;
         $this->date_avis_trajet_passagers = $date_avis_trajet_passagers;
         $this->prix_personne = $prix_personne;
         $this->voyage_ecologique = $voyage_ecologique;
         $this->date_trajet = $date_trajet;
         $this->total_trajet = $total_trajet;
    } 



    /**
     * Récupère l'id du trajet effectué
     *
     * @return id_trajets_effectues
     */
    public function getIdTrajetsEffectues()
    {
        return $this->id_trajets_effectues;
    }

    /**
     * Récupère le pseude du chauffeur
     *
     * @return pseudo_chauffeur
     */
    public function getPseudoChauffeur()
    {
        return $this->pseudo_chauffeur;
    }

    /**
     * Modifie/Affecte  le pseudo du chauffeur
     *
     * @param string $pseudo_chauffeur
     * @return pseudo_chauffeur
     */
    public function setPseudoChauffeur($pseudo_chauffeur)
    {
        $this->pseudo_chauffeur = $pseudo_chauffeur;

        return $this;
    }

    /**
     * Récupère l'email du chauffeur
     *
     * @return email_chauffeur
     */
    public function getEmailChauffeur()
    {
        return $this->email_chauffeur;
    }

    /**
     * Modifie/Affecte  l'email du chauffeur
     *
     * @param string $email_chauffeur
     * @return email_chauffeur
     */
    public function setEmailchauffeur($email_chauffeur)
    {
        $this->email_chauffeur = $email_chauffeur;

        return $this;
    }

    /**
     * Récupère les notes du chauffeur
     *
     * @return note_chauffeur
     */
    public function getNoteChauffeur()
    {
        return $this->note_chauffeur;
    }

    /**
     * Modifie/Affecte  la note du chauffeur
     *
     * @param float $note_chauffeur
     * @return note_chauffeur
     */
    public function setNoteChauffeur($note_chauffeur)
    {
        $this->note_chauffeur = $note_chauffeur;

        return $this;
    }

    /**
     * récupère la date de la note donnée à un chauffeur
     *
     * @return date_note_chauffeur
     */
    public function getDateNoteChauffeur()
    {
        return $this->date_note_chauffeur;
    }

    /**
     * Modifie/Affecte  la date de la note du chauffeur
     *
     * @param DateTime $date_note_chauffeur
     * @return date_note_chauffeur
     */
    public function setDateNoteChauffeur($date_note_chauffeur)
    {
        $this->date_note_chauffeur = $date_note_chauffeur;

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
     * Récupère la ville de l'arrivée
     *
     * @return ville_arrivee
     */
    public function getVilleArrivee()
    {
        return $this->ville_arrivee;
    }

    /**
     * Change la ville d'arrivée
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
     * récupère l'avis des passagers sur le trajet
     *
     * @return avis_trajet_passagers
     */
    public function getAvisTrajetPassagers()
    {
        return $this->avis_trajet_passagers;
    }

    /**
     * Modifie/Affecte  l'avis des passagers sur le trajet
     *
     * @param string $avis_trajet_passagers
     * @return avis_trajet_passagers
     */
    public function setAvisTrajetPassagers($avis_trajet_passagers)
    {
        $this->avis_trajet_passagers= $avis_trajet_passagers;

        return $this;
    }

    /**
     * Récupère la date de l'avis des passagers sur le trajet
     *
     * @return date_avis_trajet_passagers
     */
    public function getDateAvisTrajetPassagers()
    {
        return $this->date_avis_trajet_passagers;
    }

    /**
     * Modifie/Affecte  la date de l'avis des passagers sur le trajet
     *
     * @param DateTime $date_avis_trajet_passagers
     * @return date_avis_trajet_passagers
     */
    public function setDateAvisTrajetPassagers($date_avis_trajet_passagers)
    {
        $this->date_avis_trajet_passagers = $date_avis_trajet_passagers;

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
     * Récupère le bool du voyage écologique
     *
     * @return bool
     */
    public function getVoyageEcologique()
    {
        return $this->voyage_ecologique;
    }

    /**
     * Modifie/Affecte  le bool du voyage écologique
     *
     * @param bool $voyage_ecologique
     * @return bool
     */
    public function setVoyageEcologique($voyage_ecologique)
    {
        $this->voyage_ecologique = $voyage_ecologique;

        return $this;
    }

    /**
     * Récupère la date du trajet
     *
     * @return date_trajet
     */
    public function getDateTrajet()
    {
        return $this->date_trajet;
    }

    /**
     * Modifie/Affecte  la date du trajet
     *
     * @param DateTime $date_trajet
     * @return date_trajet
     */
    public function setDateTrajet($date_trajet)
    {
        $this->date_trajet = $date_trajet;

        return $this;
    }

    /**
     * Récupère le total des trajets
     *
     * @return total_trajet
     */
    public function getTotalTrajet()
    {
        return $this->total_trajet;
    }

    /**
     * Modifie/Affecte  le total des trajets
     *
     * @param float $total_trajet
     * @return total_trajet
     */
    public function setTotalTrajet($total_trajet)
    {
        $this->total_trajet = $total_trajet;

        return $this;
    }
  
    
}