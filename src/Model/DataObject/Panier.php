<?php

namespace App\Bracket\Model\DataObject;

class Panier extends AbstractDataObject
{
    private int $idPanier, $idArticle, $quantite;
    private string $mailClient;

    public function __construct(int $idPanier, string $mailClient, int $idBijou, int $quantite)
    {
        $this->idPanier = $idPanier;
        $this->idArticle = $idBijou;
        $this->mailClient = $mailClient;
        $this->quantite = $quantite;
    }

    public function formatTableau(): array
    {
        return array(
            "mailClientTag" => $this->getMailClient(),
            "idBijouTag" => $this->getIdArticle(),
            "quantiteTag" => $this->getQuantite()
        );
    }

    public static function construireDepuisTableau(array $tableau): Panier
    {
        return new Panier(
            0,
            $tableau["mailClient"],
            $tableau["idBijou"],
            $tableau["quantite"]
        );
    }

    /**
     * @return int
     */
    public function getIdPanier(): int
    {
        return $this->idPanier;
    }

    /**
     * @param int $idPanier
     */
    public function setIdPanier(int $idPanier): void
    {
        $this->idPanier = $idPanier;
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

    /**
     * @return int
     */
    public function getQuantite(): int
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * @return string
     */
    public function getMailClient(): string
    {
        return $this->mailClient;
    }

    /**
     * @param string $mailClient
     */
    public function setMailClient(string $mailClient): void
    {
        $this->mailClient = $mailClient;
    }




}