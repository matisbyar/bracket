<?php

namespace App\Bracket\Model\DataObject;

class Commande extends AbstractDataObject {
    private int $id;
    private string $adresse, $client;
    private array $produits;

    /**
     * @param int $id
     * @param string $adresse
     * @param string $client
     */
    public function __construct(int $id, string $adresse, string $client, array $produits)
    {
        $this->id = $id;
        $this->adresse = $adresse;
        $this->client = $client;
        $this->produits = $produits;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getClient(): string
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getProduits(): array
    {
        return $this->produits;
    }

    /**
     * @param array $produits
     */
    public function setProduits(array $produits): void
    {
        $this->produits = $produits;
    }

	/**
	 * @return array
	 */
	public function formatTableau(): array {
        return null;
	}
}