<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Controller\GenericController;
use App\Bracket\Model\DataObject\AbstractDataObject;
use App\Bracket\Model\DataObject\Article;
use PDOException;

class ArticleRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "p_articles";
    }

    protected function construire(array $objetFormatTableau): Article
    {
        return new Article(
            $objetFormatTableau["idArticle"],
            $objetFormatTableau["idBijou"],
            $objetFormatTableau["couleur"],
            $objetFormatTableau["taille"],
            $objetFormatTableau["stock"]
        );
    }

    protected function getNomClePrimaire(): string
    {
        return "idArticle";
    }

    protected function getNomColonnes(): array
    {
        return array("idArticle", "idBijou", "couleur", "taille", "stock");
    }

    public function getIdArticleParClesPrimaires(int $idBijou, string $couleur, string $taille): ?int
    {
        try {
            $requete = "SELECT idArticle FROM " . $this->getNomTable() . " WHERE idBijou = :idBijou AND couleur = :couleur AND taille = :taille";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":idBijou", $idBijou);
            $statement->bindParam(":couleur", $couleur);
            $statement->bindParam(":taille", $taille);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $resultat["idArticle"];
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'id de l'article n'a pu être faite.");
            return null;
        }
    }

    public function getArticleParIdArticle(int $idArticle): ?Article
    {
        try {
            $requete = "SELECT * FROM p_articles WHERE idArticle = :idArticle";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":idArticle", $idArticle);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $this->construire($resultat);
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'article n'a pu être faite.");
            return null;
        }
    }
}