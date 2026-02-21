<?php
// app/Entity/Voitures.php
namespace App\Entity;

class Voitures
{
    
    private string $modele;
    private string $marque;
    private string $couleur;
    private int $kilometrages;
    private string $date_1_mise_en_circulation; 
    private string $plaque_immatriculation;
    private bool $ecologique;
    private bool $animal;
    private bool $fumeur;
    private string $preferences;

    /**
     * Constructor
     */
    public function __construct(
        string $modele,
        string $marque,
        string $couleur,
        int $kilometrages,
        string $date_1_mise_en_circulation, 
        string $plaque_immatriculation,
        bool $ecologique = false,
        bool $animal = false,
        bool $fumeur = false,
        string $preferences = '',
        
    ) {
        
        $this->modele = $modele;
        $this->marque = $marque;
        $this->couleur = $couleur;
        $this->kilometrages = $kilometrages;
        $this->date_1_mise_en_circulation = $date_1_mise_en_circulation;
        $this->plaque_immatriculation = $plaque_immatriculation;
        $this->ecologique = $ecologique;
        $this->animal = $animal;
        $this->fumeur = $fumeur;
        $this->preferences = $preferences;
    }

    /**
     * Convertit un document MongoDB en objet Voitures
     */
    public static function fromDocument(array $document): self
    {
        return new self(
            $document['modele'],
            $document['marque'],
            $document['couleur'],
            $document['kilometrages'],
            $document['date_1_mise_en_circulation'], 
            $document['plaque_immatriculation'],
            $document['ecologique'] ?? false,
            $document['animal'] ?? false,
            $document['fumeur'] ?? false,
            $document['preferences'] ?? '',
            
        );
    }

    /**
     * Convertit l'objet en tableau pour MongoDB
     */
    public function toArray(): array
    {
        return [
            'modele' => $this->modele,
            'marque' => $this->marque,
            'couleur' => $this->couleur,
            'kilometrages' => $this->kilometrages,
            'date_1_mise_en_circulation' => $this->date_1_mise_en_circulation, 
            'plaque_immatriculation' => $this->plaque_immatriculation,
            'ecologique' => $this->ecologique,
            'animal' => $this->animal,
            'fumeur' => $this->fumeur,
            'preferences' => $this->preferences
        ];
    }

    // GETTERS
    

    public function getModele(): string
    {
        return $this->modele;
    }

    public function getMarque(): string
    {
        return $this->marque;
    }

    public function getCouleur(): string
    {
        return $this->couleur;
    }

    public function getKilometrages(): int
    {
        return $this->kilometrages;
    }

    public function getDate1MiseEnCirculation(): string 
    {
        return $this->date_1_mise_en_circulation;
    }

    public function getPlaqueImmatriculation(): string
    {
        return $this->plaque_immatriculation;
    }

    public function getEcologique(): bool
    {
        return $this->ecologique;
    }

    public function getAnimal(): bool
    {
        return $this->animal;
    }

    public function getFumeur(): bool
    {
        return $this->fumeur;
    }

    public function getPreferences(): string
    {
        return $this->preferences;
    }

    // SETTERS
    public function setModele(string $modele): self
    {
        $this->modele = $modele;
        return $this;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;
        return $this;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;
        return $this;
    }

    public function setKilometrages(int $kilometrages): self
    {
        $this->kilometrages = $kilometrages;
        return $this;
    }

    public function setDate1MiseEnCirculation(string $date_1_mise_en_circulation): self 
    {
        $this->date_1_mise_en_circulation = $date_1_mise_en_circulation;
        return $this;
    }

    public function setPlaqueImmatriculation(string $plaque_immatriculation): self
    {
        $this->plaque_immatriculation = $plaque_immatriculation;
        return $this;
    }

    public function setEcologique(bool $ecologique): self
    {
        $this->ecologique = $ecologique;
        return $this;
    }

    public function setAnimal(bool $animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    public function setFumeur(bool $fumeur): self
    {
        $this->fumeur = $fumeur;
        return $this;
    }

    public function setPreferences(string $preferences): self
    {
        $this->preferences = $preferences;
        return $this;
    }
}