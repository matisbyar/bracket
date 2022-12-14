<?php

namespace App\Bracket\Controller;

use App\Bracket\Model\Repository\ProduitRepository;

class ControllerProduit
{
    public static function readAll(): void
    {
        $produits = (new ProduitRepository())->readAll();
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Liste des produits", "cheminVueBody" => "produit/list.php"]);
    }

    private static function afficheVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
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
        self::afficheVue("home.php", ["produits" => $produits, "produitALaUne" => $produits[0],  "pagetitle" => "Liste des produits", "cheminVueBody" => "home.php"]);
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

    public static function create(): void{
        ControllerProduit::afficheVue('view.php',["pagetitle"=>"Création d'un bijoux","cheminVueBody"=>"produit/create.php"]);
    }

    public static function created() : void{
        $type = $_GET["bijou"];
        $prix = $_GET["prix"];
        $material = $_GET["materiau"];
        $name = $_GET["nom"];
        $description = $_GET["description"];
        $produit = (new ProduitRepository())->insert($type,$prix,$material,$name,$description);
    }
}