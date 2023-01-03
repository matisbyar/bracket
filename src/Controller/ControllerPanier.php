<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\Repository\ArticleRepository;
use App\Bracket\Model\Repository\PanierRepository;

class ControllerPanier extends GenericController
{
    public static function basket(): void
    {
        if (ConnexionClient::estConnecte()) {
            $panier = (new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte());

            self::afficheVue("view.php", ["panier" => $panier, "pagetitle" => "Bracket - Panier", "cheminVueBody" => "panier/list.php"]);
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour accéder à votre panier.");
            self::redirige("?action=home");
        }
    }

    public static function add(): void
    {
        if (ConnexionClient::estConnecte()) {
            $idBijou = $_REQUEST['idBijou'];
            $taille = $_REQUEST['taille'];
            $couleur = $_REQUEST['couleur'];
            $quantite = $_REQUEST['quantite'];
            $panier = Panier::construireDepuisTableau(array(
                "mailClient" => ConnexionClient::getLoginUtilisateurConnecte(),
                "idArticle" => (new ArticleRepository())->getIdArticleParClesPrimaires($idBijou, $couleur, $taille),
                "quantite" => $quantite));
            (new PanierRepository())->save($panier);
            MessageFlash::ajouter("success", "Le produit a bien été ajouté au panier.");
            self::basket();
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour ajouter un produit au panier.");
            self::redirige("?action=home");
        }
    }

    public static function delete(): void
    {
        if (ConnexionClient::estConnecte()) {
            (new PanierRepository)->deleteElementFromPanier(ConnexionClient::getLoginUtilisateurConnecte(), $_REQUEST["id"]);
            MessageFlash::ajouter("success", "Le produit a bien été supprimé du panier.");
            self::redirige("?action=home");
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour supprimer un produit du panier.");
            self::redirige("?action=home");
        }
    }
}