<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Controller\GenericController;
use App\Bracket\Model\DataObject\Panier;
use PDOException;

/**
 * Un utilisateur connecté possède "plusieurs paniers". Chacun contient un article et une quantité donnée.
 * Un utilisateur connecté peut avoir plusieurs paniers. Ceci est dû aux contraintes d'intégrité de la base de données.
 *
 * ATTENTION : Le mode de fonctionnement n'est pas le même que pour un utilisateur non connecté.
 */
class PanierRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "p_paniers";
    }

    protected function construire(array $objetFormatTableau): Panier
    {
        return new Panier($objetFormatTableau['0'], $objetFormatTableau['1'], $objetFormatTableau['2'], $objetFormatTableau['3']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idPanier, mailClient, idArticle";
    }

    protected function getNomColonnes(): array
    {
        return array(
            "idPanier", "mailClient", "idArticle", "quantite"
        );
    }

    public function selectPanierFromClient(string $mail): ?array
    {
        try {
            $requete = "SELECT * FROM p_paniers WHERE mailClient = :mailClient";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mail);
            $statement->execute();
            $resultat = $statement->fetchAll();
            $statement->closeCursor();
            $panier = array();
            foreach ($resultat as $panierFormatTableau) {
                $panier[] = $this->construire($panierFormatTableau);
            }
            return $panier;
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération du panier n'a pu être faite.");
            return null;
        }
    }

    public function selectPanierFromClientEtArticle(string $mail, int $idArticle): ?Panier
    {
        try {
            $requete = "SELECT * FROM p_paniers WHERE mailClient = :mailClient AND idArticle = :idArticle";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mail);
            $statement->bindParam(":idArticle", $idArticle);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $this->construire($resultat);
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération du panier n'a pu être faite.");
            return null;
        }
    }

    public function deleteElementFromPanier(string $mail, int $idArticle): void
    {
        try {
            $requete = "DELETE FROM p_paniers WHERE mailClient = :mailClient AND idArticle = :idArticle";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mail);
            $statement->bindParam(":idArticle", $idArticle);
            $statement->execute();
            $statement->closeCursor();
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La suppression de l'élément dans panier n'a pu être faite.");
        }
    }

    public function viderPanierParClient(string $mail): void
    {
        try {
            $requete = "DELETE FROM p_paniers WHERE mailClient = :mailClient";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mail);
            $statement->execute();
            $statement->closeCursor();
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La suppression de l'élément dans panier n'a pu être faite.");
        }
    }

    public function contientArticle(string $mailClient, int $idArticle): ?bool
    {
        try {
            $requete = "SELECT * FROM p_paniers WHERE mailClient = :mailClient AND idArticle = :idArticle";
            $statement = DatabaseConnection::getPdo()->prepare($requete);

            $statement->bindParam(":mailClient", $mailClient);
            $statement->bindParam(":idArticle", $idArticle);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $resultat != null;
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération du panier n'a pu être faite.");
            return null;
        }
    }

    public function modifierQuantite(string $mailClient, int $idArticle, int $quantite): void
    {
        try {
            $requete = "UPDATE p_paniers SET quantite = :quantite WHERE mailClient = :mailClient AND idArticle = :idArticle";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mailClient);
            $statement->bindParam(":idArticle", $idArticle);
            $statement->bindParam(":quantite", $quantite);
            $statement->execute();
            $statement->closeCursor();
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La modification de la quantité n'a pu être faite.");
        }
    }

    public function prixTotal(string $mailClient): ?float
    {
        try {
            $requete = "SELECT SUM(quantite * prix) AS total FROM p_paniers JOIN p_articles ON p_paniers.idArticle = p_articles.idArticle JOIN p_bijoux ON p_articles.idBijou = p_bijoux.id WHERE p_paniers.mailClient = :mailClient";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mailClient);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $resultat['total'];
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération du panier n'a pu être faite.");
            return null;
        }
    }

    public function getIdPanier(string $mailClient): ?int
    {
        try {
            $requete = "SELECT idPanier FROM p_paniers WHERE mailClient = :mailClient";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":mailClient", $mailClient);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $resultat['idPanier'];
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération du panier n'a pu être faite.");
            return null;
        }
    }
}