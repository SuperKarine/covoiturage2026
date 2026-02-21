<?php

namespace App\Entity;

use DateTime;

class Chauffeurs extends Utilisateurs
{
    /**
     * @var integer $id_chauffeurs     l'idententifiant du chauffeur en auto incrémente
     */
    protected int $id_chauffeurs;

    /**
     * @var float $moyenne_note_chauffeur   la moyenne des notes du chauffeur
     */
    protected float $moyenne_note_chauffeur;

    /**
     * @var string  $plaque_immatruculation          Numéro de la plaque d'immatriculation
     */
    protected string $plaque_immatriculation;

    /**
     * @var DateTime $date_1_mise_circulation     Date de la 1ère mise en circulation
     */
    protected DateTime $date_1_mise_circulation;

    /**
     * @var string  $modele     le modèle du véhicule
     */
    protected string $modele;

    /**
     * @var string $couleur       la couleur du véhicule
     */
    protected string $couleur;

    /**
     * @var string $marque       la marque du véhicule
     */
    protected string $marque;

    /**
     * @var boolean  $animal      Est-ce que le chauffeur prend des animaux
     */
    protected bool $animal;

    /**
     * @var boolean  $fumeur         Est-ce que le chauffeur transporte des fumeurs
     */
    protected bool $fumeur;

    /**
     * @var string  $preferences  Pour préciser si besoin des choses particulières
     */
    protected string $preferences;

    /**
     * Chauffeurs constructor 
     */
    public function __construct(
        // paramètres pour la classe parente Utilisateurs
        string $nom,
        string $prenom,
        string $pseudo,
        string $email,
        string $mot_de_passe,
        DateTime $date_naissance,
        string $telephone,
        bool $isChauffeur,

        //Paramètre de Chauffeurs
        int $id_chauffeurs,
        float $moyenne_note_chauffeur,
        string $plaque_immatriculation,
        DateTime $date_1_mise_circulation,
        string $modele,
        string $couleur,
        string $marque,
        bool $animal,
        bool $fumeur,
        string $preferences
    )
    { 
        // Appel du constructeur parent Utilisateurs
        parent::__construct($nom, $prenom, $pseudo, $email, $mot_de_passe, $date_naissance, $telephone, $isChauffeur);

        //Initialisation des propriétés de Chauffeurs
        $this->id_chauffeurs = $id_chauffeurs;
        $this->moyenne_note_chauffeur = $moyenne_note_chauffeur;
        $this->plaque_immatriculation = $plaque_immatriculation;
        $this->date_1_mise_circulation = $date_1_mise_circulation;
        $this->modele = $modele;
        $this->couleur = $couleur;
        $this->marque = $marque;
        $this->animal = $animal;
        $this->fumeur = $fumeur;
        $this->preferences = $preferences;
    }

    /**
     * Crée une instance de Chauffeurs à partir d'un tableau de données
     * Méthode alternative au constructeur pour l'hydratation depuis la BDD
     */
    public static function fromArray(array $data): self
    {
        // Convertir les chaînes de dates en objets DateTime si nécessaire
        $dateNaissance = $data['date_naissance'] ?? null;
        if (is_string($dateNaissance)) {
            $dateNaissance = DateTime::createFromFormat('Y-m-d', $dateNaissance);
        }

        $dateMiseCirculation = $data['date_1_mise_circulation'] ?? null;
        if (is_string($dateMiseCirculation)) {
            $dateMiseCirculation = DateTime::createFromFormat('Y-m-d', $dateMiseCirculation);
        }

        // Gérer les booléens (peuvent venir de la BDD comme 0/1)
        $animal = $data['animal'] ?? false;
        if (is_string($animal)) {
            $animal = $animal === '1' || $animal === 'true';
        }

        $fumeur = $data['fumeur'] ?? false;
        if (is_string($fumeur)) {
            $fumeur = $fumeur === '1' || $fumeur === 'true';
        }

        $isChauffeur = $data['isChauffeur'] ?? true;
        if (is_string($isChauffeur)) {
            $isChauffeur = $isChauffeur === '1' || $isChauffeur === 'true';
        }

        // Assurer des valeurs par défaut pour éviter les erreurs
        return new self(
            // Paramètres Utilisateurs
            $data['nom'] ?? '',
            $data['prenom'] ?? '',
            $data['pseudo'] ?? '',
            $data['email'] ?? '',
            $data['mot_de_passe'] ?? '', 
            $dateNaissance ?? new DateTime(),
            $data['telephone'] ?? '',
            $isChauffeur,

            // Paramètres Chauffeurs
            $data['id_chauffeurs'] ?? 0,
            $data['moyenne_note_chauffeur'] ?? 0.0,
            $data['plaque_immatriculation'] ?? '',
            $dateMiseCirculation ?? new DateTime(),
            $data['modele'] ?? '',
            $data['couleur'] ?? '',
            $data['marque'] ?? '',
            $animal,
            $fumeur,
            $data['preferences'] ?? ''
        );
    }

    /**
     * Récupère l'id du chauffeur
     *
     * @return id_chauffeurs
     */
    public function getIdChauffeurs()
    {
        return $this->id_chauffeurs;
    }

    /**
     * Récupère la moyenne des notes chauffeur
     *
     * @return moyenne_note_chauffeur
     */
    public function getMoyenneNoteChauffeur()
    {
        return $this->moyenne_note_chauffeur;
    }

    /**
     * Modifie/Affecte  la moyenne de la note chauffeur
     *
     * @param float $moyenne_note_chauffeur
     * @return moyenne_note_chauffeur
     */
    public function setMoyenneNoteChauffeur($moyenne_note_chauffeur)
    {
        $this->moyenne_note_chauffeur = $moyenne_note_chauffeur;

        return $this;
    }

    /**
     * Récupère la plaque d'immatriculation
     *
     * @return plaque_immatriculation
     */
    public function getPlaqueImmatriculation()
    {
        return $this->plaque_immatriculation;
    }

    /**
     * Modifie/Affecte la plaque d'immatriculation
     *
     * @param  string $plaque_immatriculation
     * @return plaque_immatriculation
     */
    public function setPlaqueImmatriculation($plaque_immatriculation)
    {
        $this->plaque_immatriculation = $plaque_immatriculation;

        return $this;
    }

    /**
     * Récupère la date de la 1ère mise en circulation
     *
     * @return date_1_mise_circulation
     */
    public function getDate1MiseCirculation()
    {
        return $this->date_1_mise_circulation;
    }

    /**
     * Modifie/Affecte  la date de la 1ère mise en circulation
     *
     * @param DateTime $date_1_mise_circulation
     * @return date_1_mise_circulation
     */
    public function setDate1MiseCirculation($date_1_mise_circulation)
    {
        $this->date_1_mise_circulation = $date_1_mise_circulation;

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
     * Modifie/Affecte  le modèle de la voiture
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
     * Récupère la couleur de la voiture
     *
     * @return couleur
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Modifie/Affecte la couleur de la voiture
     *
     * @param string $couleur
     * @return couleur
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

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
     * Modifie/Affecte  la marque de la voiture
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
     * Récupère le bool de animal
     *
     * @return bool
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * Modifie/Affecte  le bool de animal
     *
     * @param bool $animal
     * @return bool
     */
    public function setAnimal($animal)
    {
        $this->animal = $animal;

        return $this;
    }

    /**
     * Récupère le bool de fumeur
     *
     * @return bool
     */
    public function getFumeur()
    {
        return $this->fumeur;
    }

    /**
     * Modifie/Affecte  le bool de fumeur
     *
     * @param bool $fumeur
     * @return bool
     */
    public function setFumeur($fumeur)
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    /**
     * Récupère les préférences s'il y en a du chauffeur
     *
     * @return preferences
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * Modifie/Affecte  les préférences du chauffeur s'il y en a
     *
     * @param string $preferences
     * @return preferences
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;

        return $this;
    }
}