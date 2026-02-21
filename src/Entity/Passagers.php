<?php

namespace App\Entity;

use DateTime;

class Passagers extends Utilisateurs
{
    /**
     * @var integer $id_passagers     identifiant du passager en auto increment
     */
    protected int $id_passagers;

    /**
     * @var DateTime $date_heure_trajet      Date et heure du trajet
     */
    protected DateTime $date_heure_trajet;

    /**
     * @var integer $nbre_places     nombre de places disponible dans le véhicule
     */
    protected int $nbre_places;

    /**
     * @var DateTime $date_crédit_en_cours      Date du crédit en cours
     */
    protected DateTime $date_crédit_en_cours;

    /**
     * @var integer $credit_en_cours       Le montant du Crédit en cours
     */
    protected int $credit_en_cours;

    /**
     * @var integer $debit        Le montant du débit
     */
    protected int $debit;

    /**
     * @var DateTime $date_debit         Date du débit
     */
    protected DateTime $date_debit;

    /**
     * @var integer $credit_restant    Le montant du crédit restant
     */
    protected int $credit_restant;


    public function __construct(

        // paramètres pour la classe parente Utilisateurs

        string $nom,
        string $prenom,
        string $pseudo,
        string $email,
        string $mot_de_passe,
        DateTime $date_naissance,
        string $telephone,
        bool $isPassager,

        // Paramètre de Passagers

        int $id_passagers,
        DateTime $date_heure_trajet,
        int $nbre_places,
        DateTime $date_crédit_en_cours,
        int $credit_en_cours,
        int $debit,
        DateTime $date_debit,
        int $credit_restant
    )
    {
        // Appel du constructeur parent Utilisateurs
        
        parent::__construct($nom, $prenom, $pseudo, $email, $mot_de_passe, $date_naissance, $telephone, $isPassager);
        
        // Initialisation des propriétés de Passagers

        $this->id_passagers = $id_passagers;
        $this->date_heure_trajet = $date_heure_trajet;
        $this->nbre_places = $nbre_places;
        $this->date_crédit_en_cours = $date_crédit_en_cours;
        $this->credit_en_cours = $credit_en_cours;
        $this->debit = $debit;
        $this->date_debit = $date_debit;
        $this->credit_restant = $credit_restant;
    }

    
    /**
     * Récupère identifiant du passager        identifiant du passager en auto incrément
     *
     * @return id_passagers
     */
    public function getIdPassagers()
    {
        return $this->id_passagers;
    }

    /**
     * Récupère la date et l'heure du trajet
     *
     * @return date_heure_trajet
     */
    public function getDateTrajet()
    {
        return $this->date_heure_trajet;
    }

    /**
     * Modifie/Affecte  la date et l'heure du trajet
     *
     * @param DateTime $date_heure_trajet
     * @return date_heure_trajet
     */
    public function setDateTrajet($date_heure_trajet)
    {
        $this->date_heure_trajet = $date_heure_trajet;

        return $this;
    }


    /**
     * Récupère le nombre de places disponible dans la voiture
     *
     * @return nbre_places
     */
    public function getNbrePlaces()
    {
        return $this->nbre_places;
    }

    /**
     * Modifie/Affecte  le nombre de places disponible dans la voiture
     *
     * @param int $nbre_places
     * @return nbre_places
     */
    public function setNbrePlaces($nbre_places)
    {
        $this->nbre_places = $nbre_places;

        return $this;
    }

    /**
     * Récupère la date de crédit en cours
     *
     * @return date_crédit_en_cours
     */
    public function getDatecréditEnCours()
    {
        return $this->date_crédit_en_cours;
    }

    /**
     * Modifie/Affecte  la date de crédit en cours
     *
     * @param DateTime $date_crédit_en_cours
     * @return date_crédit_en_cours
     */
    public function setDateCréditEnCours($date_crédit_en_cours)
    {
        $this->date_crédit_en_cours = $date_crédit_en_cours;

        return $this;
    }

    /**
     * Récupère le crédit en cours
     *
     * @return credit_en_cours
     */
    public function getCreditEnCours()
    {
        return $this->credit_en_cours;
    }

    /**
     * Modifie/Affecte  le crédit en cours
     *
     * @param int $credit_en_cours
     * @return credit_en_cours
     */
    public function setCreditEnCours($credit_en_cours)
    {
        $this->credit_en_cours = $credit_en_cours;

        return $this;
    }

    /**
     * Récupère le débit
     *
     * @return debit
     */
    public function getDebit()
    {
        return $this->debit;
    }

    /**
     * Modifie/Affecte  le débit
     *
     * @param int $debit
     * @return debit
     */
    public function setDebit($debit)
    {
        $this->debit = $debit;

        return $this;
    }

    /**
     * Récupère la date du débit
     *
     * @return date_debit
     */
    public function getDateDebit()
    {
        return $this->date_debit;
    }

    /**
     * Modifie /Affecte la date du débit
     *
     * @param DateTime $date_debit
     * @return date_debit
     */
    public function setDateDebit($date_debit)
    {
        $this->date_debit = $date_debit;

        return $this;
    }

    /**
     * Récupère le crédit restant
     *
     * @return credit_restant
     */
    public function getCreditRestant()
    {
        return $this->credit_restant;
    }

    /**
     * Modifie/Affecte  le crédit restant
     *
     * @param int $credit_restant
     * @return credit_restant
     */
    public function setCreditRestant($credit_restant)
    {
        $this->credit_restant = $credit_restant;

        return $this;
    }

}