<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\CarteBancaire;

class CarteBancaireRepository extends AbstractRepository {
    public function construire(array $carteBancaireFormatTableau) {
        return new CarteBancaire($carteBancaireFormatTableau['0'], $carteBancaireFormatTableau['1'], $carteBancaireFormatTableau['2'], $carteBancaireFormatTableau['3']);
    }

    protected function getNomTable(): string {
        return "p_paiements";
    }

    protected function getNomClePrimaire(): string {
        return "numero";
    }
}