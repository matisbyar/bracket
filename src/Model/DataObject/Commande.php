<?php

namespace App\Bracket\Model\DataObject;

class Commande extends AbstractDataObject {

    private int $id;
    private string $adresse, $client, $statut;
    private array $produits;

    /**
     * Constructeur
     * @param int $id
     * @param string $adresse
     * @param string $client
     * @param array $produits
     * @return void
     */
    public function __construct(int $id, string $adresse, string $client, array $produits)
    {
        $this->id = $id;
        $this->adresse = $adresse;
        $this->client = $client;
        $this->produits = $produits;
        $this->statut = "en attente";
    }

    /**
     * @return string
     */
    public function getStatut(): string
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     */
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }



    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getClient(): string
    {
        return $this->client;
    }

    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    public function getProduits(): array
    {
        return $this->produits;
    }

    public function setProduits(array $produits): void
    {
        $this->produits = $produits;
    }

	public function formatTableau(): array {
        return [
            "id" => $this->getId(),
            "adresse" => $this->getAdresse(),
            "client" => $this->getClient(),
            "produits" => $this->getProduits(),
            "statut" => $this->getStatut()
        ];
	}
}