<?php

namespace App\Bracket\Model\DataObject;

class CarteBancaire extends AbstractDataObject{
    private string $numero,$ccv,$expiration,$proprietaire;

    /**
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

    /**
     * @return string
     */
    public function getNumero(): string
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return string
     */
    public function getCcv(): string
    {
        return $this->ccv;
    }

    /**
     * @param string $ccv
     */
    public function setCcv(string $ccv): void
    {
        $this->ccv = $ccv;
    }

    /**
     * @return string
     */
    public function getExpiration(): string
    {
        return $this->expiration;
    }

    /**
     * @param string $expiration
     */
    public function setExpiration(string $expiration): void
    {
        $this->expiration = $expiration;
    }

    /**
     * @return string
     */
    public function getProprietaire(): string
    {
        return $this->proprietaire;
    }

    /**
     * @param string $proprietaire
     */
    public function setProprietaire(string $proprietaire): void
    {
        $this->proprietaire = $proprietaire;
    }



}