<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Produit;
use App\Bracket\Model\Repository\ProduitRepository;

class ControllerProduit extends GenericController
{

    /**
     * Methode qui permet d'afficher la page d'affichage des produits
     * @return void
     */
    public static function readAll(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket", "cheminVueBody" => "produit/list.php"]);
    }

    /**
     * Methode qui permet de lire le detail d'un produit
     * @return void
     */
    public static function read(): void
    {
        $produit = (new ProduitRepository())->select($_GET['id']);
        if ($produit != null) self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Bracket - Détail", "cheminVueBody" => "produit/detail.php"]);
    }

    /**
     * Methode qui permet de voir tout les produits de la categorie bracelet
     * @return void
     */
    public static function readAllBracelets(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() < 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket - Bracelets", "cheminVueBody" => "produit/list.php"]);
    }

    /**
     * Methode qui permet de voir tout les produits de la categorie bagues
     * @return void
     */
    public static function readAllBagues(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        $produits = array_filter($produits, function ($produit) {
            return $produit->getId() >= 200;
        });
        self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket - Bagues", "cheminVueBody" => "produit/list.php"]);
    }

    /**
     * Methode qui permet de renvoyé sur la page de creation d'un produit
     * @return void
     */
    public static function create(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            ControllerProduit::afficheVue('view.php', ["pagetitle" => "Bracket - Création", "cheminVueBody" => "produit/create.php"]);
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::redirige("?action=home");

        }
    }

    /**
     * Methode qui permet de creer un produit
     * @return void
     */
    public static function created(): void
    {
        #2132 1190
        if (ConnexionClient::estAdministrateur()) {
            $type = $_GET["bijou"];
            $prixStr = $_GET["prix"];
            $material = $_GET["materiau"];
            $name = $_GET["nom"];
            $description = $_GET["description"];
            $image = $_GET["image"];
            $prix = floatval($prixStr);
            $produitRepository = new ProduitRepository();
            $id = $produitRepository->getId($type);
            if (getimagesize($image)[0] != 2132 && getimagesize($image)[1] != 1190) {
                MessageFlash::ajouter("warning", "La taille de l'image n'est pas conforme.");
                self::redirige("?action=home");
            } else {
                $produit = new Produit($id + 1, $type, $prix, $material, $name, $description, $image);
                $produitRepository->create($produit);
                MessageFlash::ajouter("success", "Le produit a bien été créé.");
                self::redirige("?action=readAll");
            }
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::redirige("?action=home");
        }
    }

    /**
     * Supprime un produit
     * @return void
     */
    public static function delete(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $produits = (new ProduitRepository())->selectAll();
            ControllerProduit::afficheVue('view.php', ["produits" => $produits, "pagetitle" => "Bracket - Création", "cheminVueBody" => "produit/delete.php"]);
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::redirige("?action=home");

        }
    }
    // TODO : Probléme suppression
    /**
     * Suppression d'un produit
     * @return void
     */
    public static function deleted(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            (new ProduitRepository())->delete($_GET["Produit"]);
            MessageFlash::ajouter("success", "Le produit a bien été supprimé.");
            self::redirige("?action=readAll");
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::redirige("?action=home");
        }
    }

    /**
     * Methode qui permet de renvoyé sur la page de modification d'un produit
     * @return void
     */
    public static function update(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $produit = (new ProduitRepository)->select($_GET["id"]);
            self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Modifier un produit", "cheminVueBody" => "produit/update.php"]);
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::redirige("?action=home");
        }
    }

    /**
     * Methode qui permet de modifier un produit
     * @return void
     */
    public static function updated(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $produit = (new ProduitRepository)->select($_POST["id"]);
            $produit->setPrix(floatval($_POST["prix"]));
            $produit->setNom($_POST["nom"]);
            $produit->setDescription($_POST["description"]);
            $produit->setImage($_POST["image"]);
            (new ProduitRepository)->update($produit);
            MessageFlash::ajouter("success", "Le produit a été modifié");
            self::redirige("?action=read&id=" . $produit->getId());
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::redirige("?action=home");
        }
    }
}