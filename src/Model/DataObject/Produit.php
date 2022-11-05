<?php

namespace App\Bracket\Model\DataObject;

class Produit extends AbstractDataObject  {
    private string $id, $type, $materiau, $couleur, $taille,$nom,$description;
    private float $prix;
    private int $stock;

    /**
     * @param string $id
     * @param string $type
     * @param string $materiau
     * @param string $couleur
     * @param string $taille
     * @param float $prix
     * @param int $stock
     * @param string $nom
     * @param string $description
     */
    public function __construct(string $id, string $type, float $prix, string $materiau, string $couleur, string $taille, int $stock,string $nom,string $description) {
        $this->id = $id;
        $this->type = $type;
        $this->materiau = $materiau;
        $this->couleur = $couleur;
        $this->taille = $taille;
        $this->prix = $prix;
        $this->stock = $stock;
        $this->nom = $nom;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMateriau(): string
    {
        return $this->materiau;
    }

    /**
     * @param string $materiau
     */
    public function setMateriau(string $materiau): void
    {
        $this->materiau = $materiau;
    }

    /**
     * @return string
     */
    public function getCouleur(): string
    {
        return $this->couleur;
    }

    /**
     * @param string $couleur
     */
    public function setCouleur(string $couleur): void
    {
        $this->couleur = $couleur;
    }

    /**
     * @return string
     */
    public function getTaille(): string
    {
        return $this->taille;
    }

    /**
     * @param string $taille
     */
    public function setTaille(string $taille): void
    {
        $this->taille = $taille;
    }

    /**
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}