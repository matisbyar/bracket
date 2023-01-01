<?php

namespace App\Bracket\Model\DataObject;

class Produit extends AbstractDataObject
{
    private string $id, $type, $materiau, $nom, $description,$image;
    private float $prix;

    /**
     * Constructeur
     * @param string $id
     * @param string $type
     * @param float $prix
     * @param string $materiau
     * @param string $nom
     * @param string $description
     * @param string $image
     */
    public function __construct(string $id, string $type, float $prix, string $materiau, string $nom, string $description, string $image)
    {
        $this->id = $id;
        $this->type = $type;
        $this->materiau = $materiau;
        $this->prix = $prix;
        $this->nom = $nom;
        $this->description = $description;
        $this->image = $image;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getMateriau(): string
    {
        return $this->materiau;
    }

    public function setMateriau(string $materiau): void
    {
        $this->materiau = $materiau;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * Retourne un tableau associatif contenant les propriétés de l'objet
     * @return array
     */
    public function formatTableau(): array
    {
        return array(
            "idTag" => $this->getId(),
            "typeTag"=>$this->getType(),
            "prixTag"=>$this->getPrix(),
            "materiauTag"=>$this->getMateriau(),
            "nomTag"=>$this->getNom(),
            "descriptionTag"=>$this->getDescription(),
            "imageTag"=>$this->getImage()
        );
    }

    /**
     * Construit un objet Produit à partir d'un tableau associatif
     * @param $formatTableau
     * @return Produit
     */
    public static function construireDepuisFormulaire($formatTableau) : Produit{
        return new Produit(
            $formatTableau["idTag"],
            $formatTableau["typeTag"],
            $formatTableau["prixTag"],
            $formatTableau["materiauTag"],
            $formatTableau["nomTag"],
            $formatTableau["descriptionTag"],
            $formatTableau["imageTag"]
        );
    }
}