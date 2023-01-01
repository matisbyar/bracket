<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Model\DataObject\CarteBancaire;

class CarteBancaireRepository extends AbstractRepository
{
    /**
     * Constructeur
     * @param array $carteBancaireFormatTableau
     * @return CarteBancaire
     */
    public function construire(array $carteBancaireFormatTableau): CarteBancaire
    {
        return new CarteBancaire($carteBancaireFormatTableau['0'], $carteBancaireFormatTableau['1'], $carteBancaireFormatTableau['2'], $carteBancaireFormatTableau['3']);
    }

    /**
     * Retourne le nom de la table
     * @return string
     */
    protected function getNomTable(): string
    {
        return "p_paiements";
    }

    /**
     * Retourne le nom de la cle primaire
     * @return string
     */
    protected function getNomClePrimaire(): string
    {
        return "numero";
    }

    /**
     * Retourne le nom de la colonne
     * @return string[]
     */
    protected function getNomColonnes(): array
    {
        return array(
            "numero", "ccv", "expiration", "proprietaire"
        );
    }
}