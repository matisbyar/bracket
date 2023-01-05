<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Controller\GenericController;
use App\Bracket\Model\DataObject\AbstractDataObject;
use PDOException;

abstract class AbstractRepository
{

    /**
     * Sauvegarde un objet dans la base de données
     * @param AbstractDataObject $object
     * @return void
     */
    public function create(AbstractDataObject $object): void
    {
        try {
            $sql = "INSERT INTO " . $this->getNomTable() . " (";
            foreach ($this->getNomColonnes() as $colonne) {
                $sql .= "$colonne,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ") VALUES (";
            foreach ($this->getNomColonnes() as $colonne) {
                $sql .= ":$colonne" . "Tag,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= ");";

            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($object->formatTableau());
        } catch (PDOException) {
            GenericController::error("", "Désolé ! L'insertion de l'objet n'a pu être faite.");
        }
    }

    /**
     * Récupère un objet dans la base de données
     * @param string $valeurClePrimaire
     * @return AbstractDataObject|null
     */
    public function select(string $valeurClePrimaire): ?AbstractDataObject
    {
        try {
            $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . "=:clePrimaire";
            // Préparation de la requête
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $values = array(
                "clePrimaire" => $valeurClePrimaire
            );
            // On donne les valeurs et on exécute la requête
            $pdoStatement->execute($values);
            // On récupère les résultats comme précédemment
            // Note: fetch() renvoie false si pas de voiture correspondante
            $objet = $pdoStatement->fetch();

            if ($objet != NULL) return $this->construire($objet);
            else return NULL;
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de l'objet n'a pu être faite.");
            return null;
        }
    }

    /**
     * Récupère tous les objets dans la base de données
     * @return array
     */
    public function selectAll(): ?array
    {
        try {
            $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM " . $this->getNomTable());

            $tableau = [];

            foreach ($pdoStatement as $objetFormatTableau) {
                $tableau[] = $this->construire($objetFormatTableau);
            }
            return $tableau;
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La récupération de tous les objets n'a pu être faite.");
            return null;
        }
    }

    /**
     * Met à jour un objet dans la base de données
     * @param AbstractDataObject $object
     * @return void
     */
    public function update(AbstractDataObject $object): void
    {
        try {
            $sql = "UPDATE " . $this->getNomTable() . " SET ";
            foreach ($this->getNomColonnes() as $colonne) {
                if ($colonne != $this->getNomClePrimaire()) {
                    $sql .= "$colonne = :$colonne" . "Tag,";
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= " WHERE " . $this->getNomClePrimaire() . " = :" . $this->getNomClePrimaire() . "Tag";
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($object->formatTableau());
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La mise à jour de l'objet n'a pu être faite.");
        }
    }

    /**
     * Supprime un objet dans la base de données
     * @param string $valeurClePrimaire
     * @return bool
     */
    public function delete(string $valeurClePrimaire): bool
    {
        try {
            $sql = "DELETE FROM " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . " = :clePrimaire";

            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);

            $values = array(
                "clePrimaire" => $valeurClePrimaire
            );
            $pdoStatement->execute($values);
            return true;
        } catch (PDOException) {
            GenericController::error("", "Désolé ! La suppression de l'objet n'a pu être faite.");
            return false;
        }
    }

    /**
     * Retourne le nom de la table
     * @return string
     */
    protected abstract function getNomTable(): string;

    /**
     * Construit un objet à partir d'un tableau
     * @param array $objetFormatTableau
     * @return AbstractDataObject
     */
    protected abstract function construire(array $objetFormatTableau): AbstractDataObject;

    /**
     * Retourne le nom de la clé primaire
     * @return string
     */
    protected abstract function getNomClePrimaire(): string;

    /**
     * Retourne le nom des colonnes
     * @return array
     */
    protected abstract function getNomColonnes(): array;
}