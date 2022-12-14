<?php

namespace App\Bracket\Controller;

use App\Bracket\Model\Repository\ProduitRepository;

class ControllerProduit extends GenericController
{
    public static function error($errorMessage = ""): void
    {
        self::afficheVue("view.php", ["errorMessage" => $errorMessage, "pagetitle" => "Oups :/", "cheminVueBody" => "produit/error.php"]);
    }

    public static function readAll(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des produits", "cheminVueBody" => "produit/list.php"]);
    }

    public static function read(): void
    {
        $produit = (new ProduitRepository())->select($_GET['id']);
        if ($produit != null) self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Détail d'un produit", "cheminVueBody" => "produit/detail.php"]);
    }

    public static function home(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        shuffle($produits);
        self::afficheVue("home.php", ["produits" => $produits, "produitALaUne" => $produits[0],  "pagetitle" => "Liste des produits", "cheminVueBody" => "home.php"]);
    }

    public static function readAllBracelets(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() < 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des bagues", "cheminVueBody" => "produit/list.php"]);
    }

    public static function readAllBagues(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() >= 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des bagues", "cheminVueBody" => "produit/list.php"]);
    }
}