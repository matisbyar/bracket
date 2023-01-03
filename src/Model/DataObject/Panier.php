<?php

namespace App\Bracket\Model\DataObject;

class Panier extends AbstractDataObject
{
    private int $idPanier, $idBijou, $quantite;
    private string $mailClient;

    public function __construct(int $idPanier, string $mailClient, int $idBijou, int $quantite)
    {
        $this->idPanier = $idPanier;
        $this->idBijou = $idBijou;
        $this->mailClient = $mailClient;
        $this->quantite = $quantite;
    }

    public function formatTableau(): array
    {
        return array(
            "idPanierTag" => $this->getIdPanier(),
            "mailClientTag" => $this->getMailClient(),
            "idBijouTag" => $this->getIdBijou(),
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

    public function getIdBijou(): int
    {
        return $this->idBijou;
    }

    public function setIdBijou(int $idBijou): void
    {
        $this->idBijou = $idBijou;
    }

    public function getMailClient(): string
    {
        return $this->mailClient;
    }

    public function setMailClient(string $mailClient): void
    {
        $this->mailClient = $mailClient;
    }

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
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


}