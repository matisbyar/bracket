<?php

namespace App\Bracket\Model\DataObject;

class Article extends AbstractDataObject
{
    private int $idArticle, $idBijou, $stock;
    private string $couleur, $taille;

    public function __construct(int $idArticle, int $idBijou, int $stock, string $couleur, string $taille)
    {
        $this->idArticle = $idArticle;
        $this->idBijou = $idBijou;
        $this->stock = $stock;
        $this->couleur = $couleur;
        $this->taille = $taille;
    }

    public function formatTableau(): array
    {
        return array(
            "idBijou" => $this->idBijou,
            "stock" => $this->stock,
            "couleur" => $this->couleur,
            "taille" => $this->taille
        );
    }

    public static function construireDepuisTableau(array $tableau): Article
    {
        return new Article(
            0,
            $tableau["idBijou"],
            $tableau["stock"],
            $tableau["couleur"],
            $tableau["taille"]
        );
    }

    /**
     * @return int
     */
    public function getIdBijou(): int
    {
        return $this->idBijou;
    }

    /**
     * @param int $idBijou
     */
    public function setIdBijou(int $idBijou): void
    {
        $this->idBijou = $idBijou;
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
     * @return int
     */
    public function getIdArticle(): int
    {
        return $this->idArticle;
    }

    /**
     * @param int $idArticle
     */
    public function setIdArticle(int $idArticle): void
    {
        $this->idArticle = $idArticle;
    }


}