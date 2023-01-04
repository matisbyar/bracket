<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\PanierSession;
use App\Bracket\Model\DataObject\Article;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\Repository\ArticleRepository;
use App\Bracket\Model\Repository\PanierRepository;

class ControllerPanier extends GenericController
{
    public static function basket(): void
    {
        if (ConnexionClient::estConnecte()) $panier = (new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte());
        else $panier = PanierSession::lirePanier();
        self::afficheVue("view.php", ["panier" => $panier, "pagetitle" => "Bracket - Panier", "cheminVueBody" => "panier/list.php"]);

    }

    /**
     * Ajout d'un article au panier
     * Selon le cas, on ajoute l'article au panier de la base de données ou au panier de la session (si l'utilisateur est connecté ou non respectivement)
     * On vérifie aussi si l'article est déjà dans le panier, si c'est le cas, on incrémente la quantité
     */
    public static function add(): void
    {
        $idBijou = $_REQUEST['idBijou'];
        $taille = $_REQUEST['taille'];
        $couleur = $_REQUEST['couleur'];
        $quantite = $_REQUEST['quantite'];
        $idArticle = (new ArticleRepository())->getIdArticleParClesPrimaires($idBijou, $couleur, $taille);
        if (ConnexionClient::estConnecte()) {
            if ((new PanierRepository())->contientArticle(ConnexionClient::getLoginUtilisateurConnecte(), $idArticle)) {
                $panier = (new PanierRepository())->selectPanierFromClientEtArticle(ConnexionClient::getLoginUtilisateurConnecte(), $idArticle);
                (new PanierRepository())->modifierQuantite(ConnexionClient::getLoginUtilisateurConnecte(), $idArticle, $panier->getQuantite() + $quantite);
            } else {
                $panier = Panier::construireDepuisTableau(array(
                    "mailClient" => ConnexionClient::getLoginUtilisateurConnecte(),
                    "idArticle" => $idArticle,
                    "quantite" => $quantite));
                (new PanierRepository())->save($panier);
            }
            MessageFlash::ajouter("success", "Le produit a bien été ajouté au panier.");
            self::basket();
        } else {
            $article = Article::construireDepuisTableau(array(
                "idBijou" => $idBijou,
                "stock" => $quantite,
                "couleur" => $couleur,
                "taille" => $taille
            ));
            if (PanierSession::contientArticle($article)) {
                PanierSession::modifierQuantiteArticle($article, $quantite);
            } else {
                PanierSession::ajouter($article, $quantite);
            }
            MessageFlash::ajouter("success", "Le produit a bien été ajouté au panier.");
            self::redirige("?controller=panier&action=basket");
        }
    }

    public static function delete(): void
    {
        if (ConnexionClient::estConnecte()) {
            (new PanierRepository)->deleteElementFromPanier(ConnexionClient::getLoginUtilisateurConnecte(), $_REQUEST["idArticle"]);
        } else {
            PanierSession::supprimerArticle((new ArticleRepository)->getArticleParIdArticle($_REQUEST["idArticle"]));
        }
        MessageFlash::ajouter("success", "Le produit a bien été supprimé du panier.");
        self::redirige("?controller=panier&action=basket");
    }
}