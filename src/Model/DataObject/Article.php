<?php

namespace App\Bracket\Model\DataObject;

class Article extends AbstractDataObject
{
    private int $idArticle, $idBijou, $stock;
    private string $couleur, $taille;

    public function __construct(int $idArticle, int $idBijou, string $couleur, string $taille, int $stock)
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
            "idArticleTag" => $this->getIdArticle(),
            "idBijouTag" => $this->getIdBijou(),
            "couleurTag" => $this->getCouleur(),
            "tailleTag" => $this->getTaille(),
            "stockTag" => $this->getStock(),
        );
    }

    public static function construireDepuisTableau(array $tableau): Article
    {
        return new Article(
            $tableau["idArticle"] ?? 0,
            $tableau["idBijou"],
            $tableau["couleur"],
            $tableau["taille"],
            $tableau["stock"]
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