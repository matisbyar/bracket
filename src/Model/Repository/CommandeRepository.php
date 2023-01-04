<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Controller\GenericController;
use App\Bracket\Model\DataObject\Commande;
use PDOException;

class CommandeRepository extends AbstractRepository {

    /**
     * Constructeur
     * @param array $commandeFormatTableau
     * @return Commande
     */
    public function construire (array $commandeFormatTableau): Commande {
        return new Commande($commandeFormatTableau['0'], $commandeFormatTableau['1'], $commandeFormatTableau['2'], $commandeFormatTableau['3']);
    }

    public function getCommandeParId(String $mail) : ?array {
        $sql = "SELECT * FROM ".$this->getNomTable(). " com JOIN p_contient con ON com.id=con.idCommande WHERE client = :mail ORDER BY com.id DESC;";
        //echo $sql;
        $statement = DatabaseConnection::getPdo()->prepare($sql);
        $statement->bindParam(":mail", $mail);
        $statement->execute();
        $commandes = array();
        $listeBijoux = array();
        $save = $statement->fetch();
        $resultat = $statement->fetchAll();
        foreach ($resultat as $commandeFormatTableau) {
            if($save['id'] == $commandeFormatTableau['id']) {
                echo " here";
                $bijou = (new ProduitRepository())->getProduitParId($save['idBijou']);
                $listeBijoux[] = $bijou;
                echo " enregistrement";
            }else {
                $commandeFormatTableauFinal = array();
                $commandeFormatTableauFinal[] = $commandeFormatTableau['id'];
                $commandeFormatTableauFinal[] = $commandeFormatTableau['adresse'];
                $commandeFormatTableauFinal[] = $commandeFormatTableau['client'];
                $commandeFormatTableauFinal[] = $listeBijoux;
                $listeBijoux = array();
                $commandes[] = $this->construire($commandeFormatTableauFinal);
            }
            $save = $commandeFormatTableau;
        }
        $commandeFormatTableauFinal = array();
        $commandeFormatTableauFinal[] = $save['id'];
        $commandeFormatTableauFinal[] = $save['adresse'];
        $commandeFormatTableauFinal[] = $save['client'];
        $listeBijoux[] = (new ProduitRepository())->getProduitParId($save['idBijou']);
        $commandeFormatTableauFinal[] = $listeBijoux;
        $commandes[] = $this->construire($commandeFormatTableauFinal);
        return $commandes;
    }

    /**
     * Retourne le nom de la table
     * @return string
     */
    protected function getNomTable(): string {
        return "p_commandes";
    }

    /**
     * Retourne le nom de la cle primaire
     * @return string
     */
    protected function getNomClePrimaire(): string {
        return "id";
    }

    /**
     * Retourne le nom de la colonne
     * @return string[]
     */
    protected function getNomColonnes(): array
    {
        return array(
            "id", "adresse", "client"
        );
    }
}