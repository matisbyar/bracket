<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Controller\GenericController;
use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\DataObject\Commande;
use PDOException;

class CommandeRepository extends AbstractRepository
{

    /**
     * Constructeur
     * @param array $commandeFormatTableau
     * @return Commande
     */
    public function construire(array $commandeFormatTableau): Commande
    {
        return new Commande($commandeFormatTableau['0'], $commandeFormatTableau['1'], $commandeFormatTableau['2'], $commandeFormatTableau['3']);
    }

    /**
     * Pour chaque $panier,
     * on récupère les informations de l'article correspondant
     * on récupère la quantité de l'article dans le panier
     * on récupère les informations de l'utilisateur connecté
     * insère une nouvelle ligne dans la table p_commandes : 0, adresse, client, "en traitement"
     * puis, récupère l'id de la commande insérée
     * insère une nouvelle ligne dans la table p_contient : idCommande, idArticle, quantite
     * @param array $panier
     * @return void
     */
    public function ajouterCommande(array $panier): void
    {
        $mail = ConnexionClient::getLoginUtilisateurConnecte();
        $client = (new ClientRepository())->getClientByEmail($mail);
        $adresse = $client->getAdresse();

        $requete = "SELECT id FROM p_commandes ORDER BY id DESC LIMIT 1";
        $statement = DatabaseConnection::getPdo()->prepare($requete);
        $statement->execute();
        $idCommande = $statement->fetch();
        $statement->closeCursor();
        $idCommande = $idCommande['id'] + 1;

        $requete = "INSERT INTO p_commandes (id, adresse, client, statut) VALUES (:idCommande, :adresse, :client, 'en traitement')";
        $statement = DatabaseConnection::getPdo()->prepare($requete);
        $statement->bindParam(":adresse", $adresse);
        $statement->bindParam(":client", $mail);
        $statement->bindParam(":idCommande", $idCommande);
        $statement->execute();
        $statement->closeCursor();

        $requete = "INSERT INTO p_contient (idCommande, idArticle, quantite) VALUES (:idCommande, :idArticle, :quantite)";
        $statement = DatabaseConnection::getPdo()->prepare($requete);
        $statement->bindParam(":idCommande", $idCommande);
        foreach ($panier as $article) {
            $idArticle = $article->getIdArticle();
            $quantite = $article->getQuantite();
            $statement->bindParam(":idArticle", $idArticle);
            $statement->bindParam(":quantite", $quantite);
            $statement->execute();
        }
        $statement->closeCursor();

    }

    public function getCommandeParId(int $id): ? Commande
    {
        try {
            $sql = "SELECT * FROM " . $this->getNomTable() . " com JOIN p_contient con ON com.id=con.idCommande WHERE id = :id";
            $statement = DatabaseConnection::getPdo()->prepare($sql);
            $statement->bindParam(":id", $id);
            $statement->execute();
            $resulats = $statement->fetchAll();
            $statement->closeCursor();
            $listeBijoux = array();
            foreach ($resulats as $commandeFormatTableau) {
                $bijou = (new ArticleRepository())->getArticleParIdArticle($commandeFormatTableau['idArticle']);
                $listeBijoux[] = $bijou;
                $save = $commandeFormatTableau;
            }
            $commandeFormatTableauFinal = array();
            $commandeFormatTableauFinal[] = $save['id'];
            $commandeFormatTableauFinal[] = $save['adresse'];
            $commandeFormatTableauFinal[] = $save['client'];
            $commandeFormatTableauFinal[] = $listeBijoux;
            return $this->construire($commandeFormatTableauFinal);
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'id de l'article n'a pu être faite.");
            return null;
        }
    }

    public function getQuantiteProduitCommande(int $idCommande, int $idArticle): ?int
    {
        try {
            $sql = "SELECT quantite FROM " . $this->getNomTable() . " com JOIN p_contient con ON com.id=con.idCommande WHERE id = :idCommande AND idArticle = :idArticle";
            $statement = DatabaseConnection::getPdo()->prepare($sql);
            $statement->bindParam(":idCommande", $idCommande);
            $statement->bindParam(":idArticle", $idArticle);
            $statement->execute();
            $resulats = $statement->fetch();
            $statement->closeCursor();
            return $resulats['quantite'];
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'id de l'article n'a pu être faite.");
            return null;
        }
    }

    public function getCommandeParIdClient(string $mail): ?array
    {
        try {
            $sql = "SELECT * FROM " . $this->getNomTable() . " com JOIN p_contient con ON com.id=con.idCommande WHERE client = :mail ORDER BY com.id DESC   ;";
            //echo $sql;
            $statement = DatabaseConnection::getPdo()->prepare($sql);
            $statement->bindParam(":mail", $mail);
            $statement->execute();
            $commandes = array();
            $listeBijoux = array();
            $save = $statement->fetch();
            $resultat = $statement->fetchAll();
            if (sizeof($resultat) == 0 && $save == false) {
                return array();
            } else {
                foreach ($resultat as $commandeFormatTableau) {
                    if ($save['id'] == $commandeFormatTableau['id']) {
                        $bijou = (new ArticleRepository())->getArticleParIdArticle($save['idArticle']);
                        $listeBijoux[] = $bijou;
                    } else {
                        $bijou = (new ArticleRepository())->getArticleParIdArticle($save['idArticle']);
                        $listeBijoux[] = $bijou;
                        $commandeFormatTableauFinal = array();
                        $commandeFormatTableauFinal[] = $save['id'];
                        $commandeFormatTableauFinal[] = $save['adresse'];
                        $commandeFormatTableauFinal[] = $save['client'];
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
                $bijou = (new ArticleRepository())->getArticleParIdArticle($save['idArticle']);
                $commandeFormatTableauFinal[] = $listeBijoux;
                $commandes[] = $this->construire($commandeFormatTableauFinal);
                return $commandes;
            }
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'id de l'article n'a pu être faite.");
            return null;
        }
    }

    public function getCommandes(): ?array
    {
        try {
            $sql = "SELECT * FROM " . $this->getNomTable() . " com JOIN p_contient con ON com.id=con.idCommande ORDER BY com.id ASC;";
            //echo $sql;
            $statement = DatabaseConnection::getPdo()->prepare($sql);
            $statement->execute();
            $commandes = array();
            $listeBijoux = array();
            $save = $statement->fetch();
            $resultat = $statement->fetchAll();
            if (sizeof($resultat) == 0) {
                return array();
            } else {
                foreach ($resultat as $commandeFormatTableau) {
                    if ($save['id'] == $commandeFormatTableau['id']) {
                        $bijou = (new ArticleRepository())->getArticleParIdArticle($save['idArticle']);
                        $listeBijoux[] = $bijou;
                    } else {
                        $bijou = (new ArticleRepository())->getArticleParIdArticle($save['idArticle']);
                        $listeBijoux[] = $bijou;
                        $commandeFormatTableauFinal = array();
                        $commandeFormatTableauFinal[] = $save['id'];
                        $commandeFormatTableauFinal[] = $save['adresse'];
                        $commandeFormatTableauFinal[] = $save['client'];
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
                $bijou = (new ArticleRepository())->getArticleParIdArticle($save['idArticle']);
                $commandeFormatTableauFinal[] = $listeBijoux;
                $commandes[] = $this->construire($commandeFormatTableauFinal);
                return $commandes;
            }
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'id de l'article n'a pu être faite.");
            return null;
        }
    }

    public function updateStatut(int $idCommande, string $statut): bool
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET statut = :statut WHERE id = :idCommande";
            $statement = DatabaseConnection::getPdo()->prepare($sql);
            $statement->bindParam(":statut", $statut);
            $statement->bindParam(":idCommande", $idCommande);
            $statement->execute();
            $statement->closeCursor();
            return true;
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La mise à jour du statut de la commande n'a pu être faite.");
            return false;
        }
    }

    /**
     * Retourne le nom de la table
     * @return string
     */
    protected function getNomTable(): string
    {
        return "p_commandes";
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
            "id",
            "adresse",
            "client"
        );
    }
}