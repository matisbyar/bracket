<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\Produit;

class ProduitRepository extends AbstractRepository {
    public function construire(array $produitFormatTableau) : Produit {
        return new Produit($produitFormatTableau['0'], $produitFormatTableau['1'], $produitFormatTableau['2'], $produitFormatTableau['3'], $produitFormatTableau['4'], $produitFormatTableau['5'], $produitFormatTableau['6']);
    }

    public function getNomTable() : string {
        return "p_bijoux";
    }

    public function getNomClePrimaire(): string {
        return "id";
    }
}