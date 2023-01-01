<?php

namespace App\Bracket\Model\DataObject;

class CarteBancaire extends AbstractDataObject{
    private string $numero,$ccv,$expiration,$proprietaire;

    /**
     * Constructeur
     * @param string $numero
     * @param string $ccv
     * @param string $expiration
     * @param string $proprietaire
     */
    public function __construct(string $numero, string $ccv, string $expiration, string $proprietaire)
    {
        $this->numero = $numero;
        $this->ccv = $ccv;
        $this->expiration = $expiration;
        $this->proprietaire = $proprietaire;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }

    public function getCcv(): string
    {
        return $this->ccv;
    }

    public function setCcv(string $ccv): void
    {
        $this->ccv = $ccv;
    }

    public function getExpiration(): string
    {
        return $this->expiration;
    }

    public function setExpiration(string $expiration): void
    {
        $this->expiration = $expiration;
    }

    public function getProprietaire(): string
    {
        return $this->proprietaire;
    }

    public function setProprietaire(string $proprietaire): void
    {
        $this->proprietaire = $proprietaire;
    }

    public function formatTableau() : array {
        return [
            "numero" => $this->numero,
            "ccv" => $this->ccv,
            "expiration" => $this->expiration,
            "proprietaire" => $this->proprietaire
        ];
    }

}