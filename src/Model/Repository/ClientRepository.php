<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\Client;
use PDOException;

class ClientRepository extends AbstractRepository {

    /**
     * Constructeur
     * @param array $clientFormatTableau
     * @return Client
     */
    public function construire(array $clientFormatTableau) : Client {
        return new Client($clientFormatTableau['0'], $clientFormatTableau['1'], $clientFormatTableau['2'], $clientFormatTableau['3'], $clientFormatTableau['4'], $clientFormatTableau['5'], $clientFormatTableau["6"], $clientFormatTableau['7'], $clientFormatTableau["8"]);
    }

    /**
     * Retourne le nom de la table
     * @return string
     */
    protected function getNomTable(): string {
        return "p_clients";
    }

    /**
     * Retourne le nom de la cle primaire
     * @return string
     */
    protected function getNomClePrimaire(): string {
        return "email";
    }

    /**
     * Retourne le nom de la colonne
     * @return string[]
     */
    protected function getNomColonnes(): array
    {
        return array(
            "email", "nom", "prenom", "dateNaissance", "adresse", "password", "estAdmin", "mailValide", "nonce"
        );
    }

    public function getClientByEmail(string $email) : Client {
        try {
            $requete = "SELECT * FROM " . $this->getNomTable() . " WHERE email = :email";
            $statement = DatabaseConnection::getPdo()->prepare($requete);
            $statement->bindParam(":email", $email);
            $statement->execute();
            $resultat = $statement->fetch();
            $statement->closeCursor();
            return $this->construire($resultat);
        } catch (PDOException) {
            throw new PDOException("Désolé ! La récupération du client n'a pu être faite.", 404);
        }
    }
}