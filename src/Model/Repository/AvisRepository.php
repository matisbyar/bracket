<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Model\DataObject\Avis;
use PDOException;

class AvisRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "p_avis";
    }

    protected function construire(array $objetFormatTableau): Avis
    {
        return new Avis($objetFormatTableau['0'], $objetFormatTableau['1'], $objetFormatTableau['2'], $objetFormatTableau['3']);
    }

    protected function getNomClePrimaire(): string
    {
        return "idBijou, mailClient";
    }

    protected function getNomColonnes(): array
    {
        return array(
            "idBijou", "mailClient", "note", "avis"
        );
    }

    public function getAvisByBijou(int $idBijou) : array {
        try {
            $requete = "SELECT * FROM " . $this->getNomTable() . " WHERE idBijou = :idBijou";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":idBijou", $idBijou);
            $statement->execute();
            $resultat = $statement->fetchAll();
            $statement->closeCursor();
            $avis = array();
            foreach ($resultat as $avisFormatTableau) {
                $avis[] = $this->construire($avisFormatTableau);
            }
            return $avis;
        } catch (PDOException) {
            throw new PDOException("Désolé ! La récupération des avis n'a pu être faite.", 404);
        }
    }
}