<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\PanierSession;
use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Article;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\HTTP\Session;
use App\Bracket\Model\Repository\ArticleRepository;
use App\Bracket\Model\Repository\PanierRepository;
use App\Bracket\Model\Repository\ProduitRepository;

class ControllerPanier extends GenericController
{
    public static function basket(): void
    {
            if (ConnexionClient::estConnecte()) $panier = (new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte());
            else $panier = PanierSession::lirePanier();
            self::afficheVue("view.php", ["panier" => $panier, "pagetitle" => "Bracket - Panier", "cheminVueBody" => "panier/list.php"]);

    }

    public static function add(): void
    {
        $idBijou = $_REQUEST['idBijou'];
        $taille = $_REQUEST['taille'];
        $couleur = $_REQUEST['couleur'];
        $quantite = $_REQUEST['quantite'];
        if (ConnexionClient::estConnecte()) {
            $panier = Panier::construireDepuisTableau(array(
                "mailClient" => ConnexionClient::getLoginUtilisateurConnecte(),
                "idArticle" => (new ArticleRepository())->getIdArticleParClesPrimaires($idBijou, $couleur, $taille),
                "quantite" => $quantite));
            (new PanierRepository())->save($panier);
            MessageFlash::ajouter("success", "Le produit a bien été ajouté au panier.");
            self::basket();
        } else {
            $article = Article::construireDepuisTableau(array(
                "idBijou" => $idBijou,
                "stock" => $quantite,
                "couleur" => $couleur,
                "taille" => $taille
            ));
            PanierSession::ajouter($article, $quantite);
            MessageFlash::ajouter("success", "Le produit a bien été ajouté au panier.");
            self::redirige("?controller=panier&action=basket");
        }
    }

    public static function delete(): void
    {
        if (ConnexionClient::estConnecte()) {
            (new PanierRepository)->deleteElementFromPanier(ConnexionClient::getLoginUtilisateurConnecte(), $_REQUEST["id"]);
            MessageFlash::ajouter("success", "Le produit a bien été supprimé du panier.");
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour supprimer un produit du panier.");
        }
        self::redirige("?action=home");
    }
}