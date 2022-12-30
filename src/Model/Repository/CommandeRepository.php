<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\Commande;

class CommandeRepository extends AbstractRepository {

    /**
     * Constructeur
     * @param array $commandeFormatTableau
     * @return Commande
     */
    public function construire (array $commandeFormatTableau): Commande {
        return new Commande($commandeFormatTableau['0'], $commandeFormatTableau['1'], $commandeFormatTableau['2'], $commandeFormatTableau['3']);
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