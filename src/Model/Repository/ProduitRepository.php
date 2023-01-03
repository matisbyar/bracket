<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Article;
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
            "id", "type", "prix", "materiau", "nom", "description", "image"
        );
    }

    /**
     * Retourne le produit par son type de bijou
     * @param $typeBijou
     * @return int
     */
    public function getId($typeBijou): int
    {
        try {
            $sql = "SELECT id FROM p_bijoux WHERE type=:typeBijou ORDER BY id DESC LIMIT 1;";
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $values = array("typeBijou" => $typeBijou);
            $pdoStatement->execute($values);
            return $pdoStatement->fetch()["id"];
        } catch (PDOException) {
            echo "La requête a échoué. Merci de réessayer.";
            return false;
        }
    }

    /**
     * Récupère l'ensemble des articles à partir de l'idBijou et les retourne sous forme de tableau d'objets Article
     * Il prend en compte uniquement les couleurs et les tailles de l'article
     * Uniquement pour un stock supérieur à 0
     * @return array
     */
    public static function getDisponibles($idBijou): array
    {
        try {
            $sql = "SELECT * FROM p_articles WHERE idBijou=:idBijou AND stock>0;";
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $values = array(
                "idBijou" => $idBijou
            );
            $pdoStatement->execute($values);

            $tableauArticles = [];

            foreach ($pdoStatement as $articleFormatTableau) {
                $tableauArticles[] = (new ArticleRepository)->construire($articleFormatTableau);
            }

            return $tableauArticles;
        } catch (PDOException) {
            echo "La requête a échoué. Merci de réessayer.";
            return [];
        }
    }

    public static function estEnStock($idBijou): bool
    {
        return self::getDisponibles($idBijou) != [];
    }
}