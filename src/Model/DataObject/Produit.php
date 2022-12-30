<?php

namespace App\Bracket\Model\DataObject;

class Produit extends AbstractDataObject
{
    private string $id, $type, $materiau, $nom, $description,$image;
    private float $prix;

    /**
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

    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

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