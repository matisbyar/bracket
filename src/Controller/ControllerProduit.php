<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Produit;
use App\Bracket\Model\Repository\ProduitRepository;

class ControllerProduit extends GenericController
{
    public static function readAll(): void
    {
        $produits = (new ProduitRepository())->readAll();
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket", "cheminVueBody" => "produit/list.php"]);
    }

    public static function read(): void
    {
        $produit = (new ProduitRepository())->read($_GET['id']);
        if ($produit != null) self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Bracket - Détail", "cheminVueBody" => "produit/detail.php"]);
    }

    public static function home(): void
    {
        $produits = (new ProduitRepository())->readAll();
        shuffle($produits);
        self::afficheVue("view.php", ["produits" => $produits, "produitALaUne" => $produits[0], "pagetitle" => "Bracket", "cheminVueBody" => "home.php"]);
    }

    public static function readAllBracelets(): void
    {
        $produits = (new ProduitRepository())->readAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() < 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket - Bracelets", "cheminVueBody" => "produit/list.php"]);
    }

    public static function readAllBagues(): void
    {
        $produits = (new ProduitRepository())->readAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() >= 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket - Bagues", "cheminVueBody" => "produit/list.php"]);
    }

    public static function create(): void
    {
        ControllerProduit::afficheVue('view.php', ["pagetitle" => "Bracket - Création", "cheminVueBody" => "produit/create.php"]);
    }

    public static function created(): void
    {
        $type = $_GET["bijou"];
        $prixStr = $_GET["prix"];
        $material = $_GET["materiau"];
        $name = $_GET["nom"];
        $description = $_GET["description"];
        $image = $_GET["image"];
        $prix = floatval($prixStr);
        $produitRepository = new ProduitRepository();
        $id = $produitRepository->getId($type);
        var_dump(gettype($prix));
        $produit = new Produit($id + 1, $type, $prix, $material, $name, $description, $image);
        $produitRepository->create($produit);
        MessageFlash::ajouter("success", "Le produit a bien été créé");
        self::redirige("?action=readAll");
    }

    public static function update(): void
    {
        $produit = (new ProduitRepository)->read($_GET["id"]);
        self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Modifier un produit", "cheminVueBody" => "produit/update.php"]);
    }

    public static function updated(): void
    {
        $produit = (new ProduitRepository)->read($_POST["id"]);
        $produit->setPrix(floatval($_POST["prix"]));
        $produit->setNom($_POST["nom"]);
        $produit->setDescription($_POST["description"]);
        $produit->setImage($_POST["image"]);
        (new ProduitRepository)->update($produit);
        MessageFlash::ajouter("success", "Le produit a été modifié");
        self::redirige("?action=read&id=" . $produit->getId());
    }
}