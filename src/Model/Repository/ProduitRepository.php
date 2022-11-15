<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\Produit;

class ProduitRepository extends AbstractRepository {
    public function construire(array $produitFormatTableau) : Produit {
        return new Produit($produitFormatTableau['0'], $produitFormatTableau['1'], $produitFormatTableau['2'], $produitFormatTableau['3'], $produitFormatTableau['4'], $produitFormatTableau['5']);
    }

    protected function getNomTable() : string {
        return "p_bijoux";
    }

    protected function getNomClePrimaire(): string {
        return "id";
    }
}