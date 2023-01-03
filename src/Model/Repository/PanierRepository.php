<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Model\DataObject\Panier;
use PDOException;

class PanierRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "p_panier";
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

    public function selectPanierFromClient(string $mail): array
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
            throw new PDOException("Désolé ! La récupération du panier n'a pu être faite.", 404);
        }
    }
}