<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Model\DataObject\Produit;

class ProduitRepository extends AbstractRepository
{
    public function construire(array $produitFormatTableau): Produit
    {
        return new Produit($produitFormatTableau['0'], $produitFormatTableau['1'], $produitFormatTableau['2'], $produitFormatTableau['3'], $produitFormatTableau['4'], $produitFormatTableau['5'], $produitFormatTableau['6']);
    }

    protected function getNomTable(): string
    {
        return "p_bijoux";
    }

    protected function getNomClePrimaire(): string
    {
        return "id";
    }

    protected function getNomColonnes(): array
    {
        return array(
            "id", "type", "prix", "materiau", "nom", "description","image"
        );
    }

    public function getId($typeBijou) : int
    {
        try {
            $sql = "SELECT id FROM p_bijoux WHERE type=:typeBijou ORDER BY id DESC LIMIT 1;";
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $values = array("typeBijou" => $typeBijou);
            $pdoStatement->execute($values);
            return $pdoStatement->fetch()["id"];
        }catch (PDOException) {
            echo "La mise à jour a échoué. Merci de réessayer.";
            return false;
        }
    }
}