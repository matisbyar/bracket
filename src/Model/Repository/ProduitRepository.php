<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Model\DataObject\Produit;
use PDOException;

class ProduitRepository extends AbstractRepository
{
    /**
     * Constructeur
     * @param array $produitFormatTableau
     * @return Produit
     */
    public function construire(array $produitFormatTableau): Produit
    {
        return new Produit($produitFormatTableau['0'], $produitFormatTableau['1'], $produitFormatTableau['2'], $produitFormatTableau['3'], $produitFormatTableau['4'], $produitFormatTableau['5'], $produitFormatTableau['6']);
    }

    /**
     * Retourne le nom de la table
     * @return string
     */
    protected function getNomTable(): string
    {
        return "p_bijoux";
    }

    /**
     * Retourne le nom de la cle primaire
     * @return string
     */
    protected function getNomClePrimaire(): string
    {
        return "id";
    }

    /**
     * Retourne le nom de la colonne
     * @return string[]
     */
    protected function getNomColonnes(): array
    {
        return array(
            "id", "type", "prix", "materiau", "nom", "description","image"
        );
    }

    /**
     * Retourne le produit par son id
     * @param $typeBijou
     * @return int
     */
    public function getId ($typeBijou) : int
    {
        try {
            $sql = "SELECT id FROM p_bijoux WHERE type=:typeBijou ORDER BY id DESC LIMIT 1;";
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $values = array("typeBijou" => $typeBijou);
            $pdoStatement->execute($values);
            return $pdoStatement->fetch()["id"];
        }catch (PDOException) {
            echo "La requête a échoué. Merci de réessayer.";
            return false;
        }
    }
}