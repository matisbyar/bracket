<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Produit;
use App\Bracket\Model\Repository\ProduitRepository;

class ControllerProduit  extends GenericController{
    public static function readAll(): void
    {
        $produits = (new ProduitRepository())->readAll();
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des produits", "cheminVueBody" => "produit/list.php"]);
    }

    public static function read(): void
    {
        $produit = (new ProduitRepository())->read($_GET['id']);
        if ($produit != null) self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Détail d'un produit", "cheminVueBody" => "produit/detail.php"]);
    }

    public static function error($errorMessage = ""): void
    {
        self::afficheVue("view.php", ["errorMessage" => $errorMessage, "pagetitle" => "Oups :/", "cheminVueBody" => "produit/error.php"]);
    }

    public static function home(): void
    {
        $produits = (new ProduitRepository())->readAll();
        shuffle($produits);
        self::afficheVue("view.php", ["produits" => $produits, "produitALaUne" => $produits[0], "pagetitle" => "Liste des produits", "cheminVueBody" => "home.php"]);
    }

    public static function readAllBracelets(): void
    {
        $produits = (new ProduitRepository())->readAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() < 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des bagues", "cheminVueBody" => "produit/list.php"]);
    }

    public static function readAllBagues(): void
    {
        $produits = (new ProduitRepository())->readAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() >= 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des bagues", "cheminVueBody" => "produit/list.php"]);
    }

    public static function create(): void
    {
        ControllerProduit::afficheVue('view.php', ["pagetitle" => "Création d'un bijoux", "cheminVueBody" => "produit/create.php"]);
    }

    public static function created(): void
    {
        $type = $_GET["bijou"];
        $prix = $_GET["prix"];
        $material = $_GET["materiau"];
        $name = $_GET["nom"];
        $description = $_GET["description"];
        $produit = new Produit($type, floatval($prix), $material, $name, $description);
        $produitRepository = new ProduitRepository();
        $produitRepository->create($produit);
        $produits = (new ProduitRepository())->readAll();
        MessageFlash::ajouter("success","Le produit a bien été créé");
        self::redirige("?action=readAll");
    }
}