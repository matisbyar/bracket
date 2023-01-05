<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Article;
use App\Bracket\Model\Repository\ArticleRepository;
use App\Bracket\Model\Repository\ProduitRepository;

class ControllerArticle extends GenericController
{
    public static function create(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $produits = (new ProduitRepository())->selectAll();
            self::afficheVue("view.php", ["produits" => $produits, "pagetitle" => "Bracket - Ajout d'un article", "cheminVueBody" => "article/create.php"]);
        } else {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits pour accéder à cette page.");
            self::home();
        }
    }

    public static function created(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            if (isset($_REQUEST["idBijou"]) && isset($_REQUEST["taille"]) && isset($_REQUEST["couleur"]) && isset($_REQUEST["quantite"])) {
                $idBijou = $_REQUEST["idBijou"];
                $taille = $_REQUEST["taille"];
                $couleur = $_REQUEST["couleur"];
                $quantite = intval($_REQUEST["quantite"]);

                $articleExiste = (new ArticleRepository())->getIdArticleParClesPrimaires($idBijou, $couleur, $taille);
                if ($articleExiste == null) {
                    $article = Article::construireDepuisTableau(["idBijou" => $idBijou, "taille" => $taille, "couleur" => $couleur, "stock" => $quantite]);
                    (new ArticleRepository())->create($article);
                    MessageFlash::ajouter("success", "Article ajouté avec succès.");
                    self::redirige("?controller=produit&action=read&id=" . $idBijou);
                } else {
                    $article = Article::construireDepuisTableau(["idArticle" => $articleExiste, "idBijou" => $idBijou, "taille" => $taille, "couleur" => $couleur, "stock" => $quantite]);
                    (new ArticleRepository())->update($article);
                    MessageFlash::ajouter("success", "Article mis à jour avec succès.");
                    self::redirige("?controller=produit&action=read&id=" . $idBijou);
                }
            } else {
                MessageFlash::ajouter("danger", "Une erreur est survenue lors de la création de l'article.");
                self::home();
            }
        } else {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits pour accéder à cette page.");
            self::home();
        }
    }
}