<?php

namespace App\Entity;

use DateTime;

class Utilisateurs
{

    /**
     * @var integer $id_utilisateurs  identifiant de l'utilisateur (généré automatiquement)
     */
    protected $id_utilisateurs;

    /** 
     * @var string $nom  nom de l'utilisateur
    */
    protected $nom;

    /**
     * @var string $prenom   prenom de l'utilisateur
     */

    protected $prenom;

    /**
     * @var string  $pseudo     pseudo de l'utilisateur
     */

    protected $pseudo;

    /**
     * @var string $email        email de l'utilisateur
     */

    protected $email;

    /**
     * @var string $mot_de_passe    mot_de_passe de l'utilisateur
     */

    protected $mot_de_passe;

    /**
     * @var DateTime|null $date_naissance     date_naissance de l'utilisateur
     */
    protected $date_naissance = null;

    /**
     * @var string|null $telephone  telephone de l'utilisateur
     */
    protected $telephone;

    /**
     * @var boolean  $isAdmin      Si l'utilisateur est l'administrateur
     */
    protected $isAdmin = false;


    /**
     * @var boolean $isEmploye      Si l'utilisateur est un employé
     */
    protected $isEmploye = false;

    /**
     * @var boolean $isPassager    Si l'utilisateur est un passager
     */
    protected $isPassager = false;

    /**
     * @var boolean $isChauffeur    Si l'utilisateur est un chauffeur
     */
    protected $isChauffeur = false;

    /**
     * @var boolean $isPassagerChauffeur      Si l'utilisateur est un passager/chauffeur
     */
    protected $isPassagerChauffeur = false;

    /**
     * @var integer $credits      Le crédit de l'utilisateur
     */
    protected $credits = 0;

    /**
     * @var DateTime $date_credit      Pour la date de crédit de l'utilisateur
     */
    protected $date_credit;

    /**
     * @var integer $debit Pour le débit de l'utilisateur
     */
    protected $debit = 0;

    /**
     * @var DateTime $date_debit      pour la date du débit de l'utilisateur
     */
    protected $date_debit;

    /**
     * @var integer $id_chauffeur   Pour rattacher l'identifiant du chauffeur à l'utilsateur
     */
    protected $id_chauffeur;

    /**
     * @var integer $id_passager       Pour rattacher l'identifiant du passager à l'utilisateur
     */
    protected $id_passager;



    public function __construct(
        int $id_utilisateurs,
        string $nom,
        string $prenom,
        string $pseudo,
        string $email,
        string $mot_de_passe,
        ?\DateTime $date_naissance,
        ?string $telephone,
        bool $isEmploye,
        bool $isPassager,
        bool $isChauffeur,
        bool $isPassagerChauffeur,
        int $credits,
        DateTime $date_credit,
        int $debit,
        DateTime $date_debit,
        int $id_chauffeur,
        int $id_passager

    ) {
         $this->id_utilisateurs = $id_utilisateurs;
         $this->nom = $nom;
         $this->prenom = $prenom;
         $this->pseudo = $pseudo;
         $this->email = $email;
         $this->mot_de_passe = $mot_de_passe;
         $this->date_naissance = $date_naissance;
         $this->telephone = $telephone;
         $this->isEmploye = $isEmploye;
         $this->isPassager = $isPassager;
         $this->isChauffeur = $isChauffeur;
         $this->isPassagerChauffeur = $isPassagerChauffeur;
         $this->credits = $credits;
         $this->date_credit = $date_credit;
         $this->debit = $debit;
         $this->date_debit = $date_debit;
         $this->id_chauffeur = $id_chauffeur;
         $this->id_passager = $id_passager;
    }


    /**
     * Récupère l'identifiant de l'utilisateur
     *
     * @return integer get_id_utilisateurs             identifiant de l'utilisateur en auto incrémente
     */
    public function getIdUtilisateurs()
    {
        return $this->id_utilisateurs;
    }

    /**
     * Récupère le nom de l'utilisateur
     *
     * @return nom
     */
    public function getNom ()
    {
        return $this->nom;
    }

    /**
     * Récupère le prénom de l'utilisateur
     *
     * @return prenom
     */
    public function getPrenom ()
    {
        return $this->prenom;
    }

    /**
     * Récupère le pseudo de l'utilisateur
     *
     * @return pseudo
     */
    public function getPseudo ()
    {
        return $this->pseudo;
    }

    /**
     * Modifie/Affecte  l'email de l'utilisateur
     *
     * @param string $email
     * @return $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Modifie/Affecte  le numéro de téléphone de l'utilisateur
     *
     * @param int $telephone
     * @return telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Récupère si l'utilisateur est admin
     *
     * @return isAdmin
     */
    public function getIsAdmin ()
    {
        return $this->isAdmin;
    }

    /**
     * Récupère si l'utilisateur passager
     *
     * @return isPassager
     */
    public function getIsPassager ()
    {
        return $this->isPassager;
    }

    /**
     * Modifie/Affecte  l'utilisateur passager
     *
     * @param bool isPassager
     * @return isPassager
     */
    public function setIsPassager($isPassager)
    {
        $this->isPassager = $isPassager;

        return $this;
    }

    /**
     * Récupère si l'utilisateur Chauffeur
     *
     * @return isChauffeur
     */
    public function getIsChauffeur ()
    {
        return $this->isChauffeur;
    }

     /**
     * Modifie/Affecte  l'utilisateur Chauffeur
     *
     * @param bool isChauffeur
     * @return isChauffeur
     */
    public function setIsChauffeur($isChauffeur)
    {
        $this->isChauffeur = $isChauffeur;

        return $this;
    }

    /**
     * Récupère le crédit de l'utilisateur
     *
     * @return credits
     */
    public function getCredits ()
    {
        return $this->credits;
    }

    /**
     * Modifie/Affecte  le crédit de l'utilisateur
     *
     * @param int $credits
     * @return $credits
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Récupère la date_credit de l'utilisateur
     *
     * @return date_credit
     */
    public function getDateCredit ()
    {
        return $this->date_credit;
    }

    /**
     * Modifie/Affecte  la date_credit de l'utilisateur
     *
     * @param int $date_credit
     * @return $date_credit
     */
    public function setDateCredit($date_credit)
    {
        $this->date_credit = $date_credit;

        return $this;
    }

    /**
     * Récupère le debit de l'utilisateur
     *
     * @return debit
     */
    public function getDebit ()
    {
        return $this->debit;
    }

    /**
     * Modifie/Affecte  le debit de l'utilisateur
     *
     * @param int $debit
     * @return $debit
     */
    public function setDebit($debit)
    {
        $this->debit = $debit;

        return $this;
    }

    /**
     * Récupère la date_debit de l'utilisateur
     *
     * @return date_debit
     */
    public function getDateDebit ()
    {
        return $this->date_debit;
    }

    /**
     * Modifie/Affecte  la date_debit de l'utilisateur
     *
     * @param int $date_debit
     * @return $date_debit
     */
    public function setDateDebit($date_debit)
    {
        $this->date_debit = $date_debit;

        return $this;
    }


}
