<?php

namespace App\Bracket\Model\DataObject;

class Commande extends AbstractDataObject {

    private int $id;
    private string $adresse, $client, $statut;
    private array $articles;

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
        $this->articles = $produits;
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

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function setArticles(array $articles): void
    {
        $this->articles = $articles;
    }

	public function formatTableau(): array {
        return [
            "id" => $this->getId(),
            "adresse" => $this->getAdresse(),
            "client" => $this->getClient(),
            "produits" => $this->getArticles(),
            "statut" => $this->getStatut()
        ];
	}
}