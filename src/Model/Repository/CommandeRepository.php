<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\Commande;

class CommandeRepository extends AbstractRepository {
    public function construire (array $commandeFormatTableau): Commande {
        return new Commande($commandeFormatTableau['0'], $commandeFormatTableau['1'], $commandeFormatTableau['2'], $commandeFormatTableau['3']);
    }

    protected function getNomTable(): string {
        return "p_commandes";
    }

    protected function getNomClePrimaire(): string {
        return "id";
    }
}