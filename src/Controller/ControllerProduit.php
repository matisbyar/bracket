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
        if (sizeof($produits) > 0) self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket", "cheminVueBody" => "produit/list.php"]);
        else {
            MessageFlash::ajouter("info", "Oh oh... Il y a quelque chose de cassé... Revenez plus tard ;)");
            self::home();
        }
    }

    /**
     * Methode qui permet de lire le detail d'un produit
     * @return void
     */
    public static function read(): void
    {
        if (isset($_GET['id'])) {
            $produit = (new ProduitRepository())->select($_GET['id']);
            if ($produit != null) self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Bracket - Détail", "cheminVueBody" => "produit/detail.php"]);
            else {
                MessageFlash::ajouter("danger", "Le produit n'existe pas !");
                self::home();
            }
        } else {
            MessageFlash::ajouter("warning", "Le produit n'existe pas !");
            self::home();
        }
    }

    /**
     * Methode qui permet de voir tous les produits de la catégorie bracelet
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
     * Methode qui permet de voir tous les produits de la categorie bagues
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
     * Renvoie sur la page de creation d'un produit
     * @return void
     */
    public static function create(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            ControllerProduit::afficheVue('view.php', ["pagetitle" => "Bracket - Création", "cheminVueBody" => "produit/create.php"]);
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::home();
        }
    }

    /**
     * Crée un produit
     * @return void
     */
    public static function created(): void
    {
        if (isset($_GET['bijou']) && isset($_GET['prix']) && isset($_GET['materiau']) && isset($_GET['nom']) && isset($_GET['description']) && isset($_GET['image'])) {
            if (ConnexionClient::estAdministrateur()) {
                $type = $_GET["bijou"];
                $prixStr = $_GET["prix"];
                $material = $_GET["materiau"];
                $name = ucfirst($_GET["nom"]);
                $description = $_GET["description"];
                $image = $_GET["image"];
                $prix = floatval($prixStr);
                $produitRepository = new ProduitRepository();
                $id = $produitRepository->getId($type);

                if (!filter_var($image, FILTER_VALIDATE_URL)) {
                    MessageFlash::ajouter("warning", "Veuillez entrez un lien valide.");
                    self::afficheVue('view.php', ['prix' => $_GET['prix'], 'materiau' => $_GET['materiau'], 'nom' => $_GET['nom'], 'description' => $_GET['description'], "pagetitle" => "Bracket - Création", "cheminVueBody" => "produit/create.php"]);
                } else if (getimagesize($image)[0] != 2132 && getimagesize($image)[1] != 1190) {
                    MessageFlash::ajouter("warning", "La taille de l'image n'est pas conforme.");
                    self::afficheVue('view.php', ['prix' => $_GET['prix'], 'materiau' => $_GET['materiau'], 'nom' => $_GET['nom'], 'description' => $_GET['description'], "pagetitle" => "Bracket - Création", "cheminVueBody" => "produit/create.php"]);
                } else {
                    $produit = new Produit($id + 1, $type, $prix, $material, $name, $description, $image);
                    $produitRepository->create($produit);
                    MessageFlash::ajouter("success", "Le produit a bien été créé.");
                    self::readAll();
                }
            } else {
                MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
                self::home();
            }
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
            self::home();

        }
    }

    /**
     * Suppression d'un produit
     * @return void
     */
    public static function deleted(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            if (isset($_GET['id'])) {
                (new ProduitRepository())->delete($_GET["id"]);
                MessageFlash::ajouter("success", "Le produit a bien été supprimé.");
                self::redirige("?action=readAll");
            } else {
                MessageFlash::ajouter("warning", "Le produit n'existe pas.");
                self::redirige("?action=home");
            }
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::home();
        }
    }

    /**
     * Methode qui permet de renvoyé sur la page de modification d'un produit
     * @return void
     */
    public static function update(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            if (isset($_GET['id'])) {
                $produit = (new ProduitRepository)->select($_GET["id"]);
                self::afficheVue("view.php", ["produit" => $produit, "pagetitle" => "Modifier un produit", "cheminVueBody" => "produit/update.php"]);
            } else {
                MessageFlash::ajouter("warning", "Le produit n'existe pas.");
                self::redirige("?action=home");
            }
        }else{
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour accéder à cette page.");
            self::home();
        }
    }

    /**
     * Methode qui permet de modifier un produit
     * @return void
     */
    public static function updated(): void
    {
        if (isset($_POST["id"]) && isset($_POST["prix"]) && isset($_POST["nom"]) && isset($_POST["description"]) && isset($_POST["image"])) {
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
                self::home();
            }
        } else {
            MessageFlash::ajouter("warning", "Une erreur est survenue.");
            self::home();
        }
    }
}