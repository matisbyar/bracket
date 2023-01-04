<?php

namespace App\Bracket\Lib;

use App\Bracket\Model\DataObject\Article;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\HTTP\Session;
use App\Bracket\Model\Repository\ArticleRepository;
use App\Bracket\Model\Repository\PanierRepository;
use App\Bracket\Model\Repository\ProduitRepository;

/**
 * Un utilisateur non connecté dispose d'un panier en session. Il peut donc ajouter des articles au panier, les supprimer, etc.
 *
 * ATTENTION : Le mode de fonctionnement est différent de celui d'un panier en base de données.
 * En effet, un panier en base de données est associé à un utilisateur et n'est pas unique pour des raisons de contraintes d'intégrité.
 */
class PanierSession
{
    // Les articles du panier sont enregistrés en session associée à la clé suivante
    private static string $clePanier = "_panier";

    /**
     * Ajout d'un article au panier
     * @param Article $article
     * @return void
     */
    public static function ajouter(Article $article, int $quantite): void
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        $panier[] = ["ligne" => ["article" => $article, "quantite" => $quantite]];
        Session::getInstance()->enregistrer(self::$clePanier, $panier);
    }

    /**
     * Retourne si le panier contient l'article en paramètre
     * @param Article $article
     * @return bool
     */
    public static function contientArticle(Article $article): bool
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        foreach ($panier as $articlePanier) {
            if ($articlePanier["ligne"]["article"]->getIdBijou() === $article->getIdBijou()) return true;
        }
        return false;
    }

    /**
     * Permet de récupérer le panier
     * @return array
     */
    public static function lirePanier(): array
    {
        return Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
    }

    /**
     * Permet de récupérer tous les articles du panier
     * @return array
     */
    public static function lireArticles(): array
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        $articles = [];
        foreach ($panier as $articlePanier) {
            $articles[] = $articlePanier["ligne"]["article"];
        }
        return $articles;
    }

    /**
     * Permet de récupérer toutes les quantités du panier
     * @return array
     */
    public static function lireQuantites(): array
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        $quantites = [];
        foreach ($panier as $articlePanier) {
            $quantites[] = $articlePanier["ligne"]["quantite"];
        }
        return $quantites;
    }

    /**
     * Permet de récupérer tous les articles et quantités du panier
     * @return array
     */
    public static function lireArticlesQuantites(): array
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        $articlesQuantites = [];
        foreach ($panier as $articlePanier) {
            $articlesQuantites[] = $articlePanier["ligne"];
        }
        return $articlesQuantites;
    }

    /**
     * Permet de récupérer le nombre d'articles dans le panier
     * @return int
     */
    public static function nombreArticles(): int
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        return count($panier);
    }

    /**
     * Permet de récupérer le nombre total d'articles dans le panier
     * @return int
     */
    public static function nombreTotalArticles(): int
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        $nombreTotalArticles = 0;
        foreach ($panier as $articlePanier) {
            $nombreTotalArticles += $articlePanier["ligne"]["quantite"];
        }
        return $nombreTotalArticles;
    }

    /**
     * Permet de récupérer le prix total du panier
     * @return float
     */
    public static function prixTotal(): float
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        $prixTotal = 0;
        foreach ($panier as $articlePanier) {
            $produit = (new ProduitRepository())->getProduitParId((new ArticleRepository())->getIdArticleParClesPrimaires($articlePanier["ligne"]["article"]->getIdBijou(), $articlePanier["ligne"]["article"]->getCouleur(), $articlePanier["ligne"]["article"]->getTaille()));
            $quantite = $articlePanier["ligne"]["quantite"];
            $prixTotal += $produit->getPrix() * $quantite;
        }
        return $prixTotal;
    }

    /**
     * Permet de vider le panier
     * @return void
     */
    public static function vider(): void
    {
        Session::getInstance()->supprimer(self::$clePanier);
    }

    /**
     * Permet de supprimer un article du panier
     * @param Article $article
     * @return void
     */
    public static function supprimerArticle(Article $article): void
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        foreach ($panier as $key => $articlePanier) {
            if ($articlePanier["ligne"]["article"]->getIdBijou() === $article->getIdBijou()) {
                unset($panier[$key]);
                break;
            }
        }
        Session::getInstance()->enregistrer(self::$clePanier, $panier);
    }

    /**
     * Permet de modifier la quantité d'un article du panier
     * @param Article $article
     * @param int $quantite
     * @return void
     */
    public static function modifierQuantiteArticle(Article $article, int $quantite): void
    {
        $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
        foreach ($panier as $key => $articlePanier) {
            if ($articlePanier["ligne"]["article"]->getIdBijou() === $article->getIdBijou()) {
                $panier[$key]["ligne"]["quantite"] += $quantite;
                break;
            }
        }
        Session::getInstance()->enregistrer(self::$clePanier, $panier);
    }

    /**
     * Permet de migrer les données du panier de la session vers la base de données.
     * @return array Tableau contenant chaque ligne sous forme de Panier.
     */
    public static function migrerVersCompte(): void
    {
        $lignes = [];

        if (ConnexionClient::estConnecte()) {
            $idClient = ConnexionClient::getLoginUtilisateurConnecte();
            $panier = Session::getInstance()->contient(self::$clePanier) ? Session::getInstance()->lire(self::$clePanier) : [];
            foreach ($panier as $articlePanier) {
                $article = $articlePanier["ligne"]["article"];
                $quantite = $articlePanier["ligne"]["quantite"];
                $idArticle = (new ArticleRepository)->getIdArticleParClesPrimaires($article->getIdBijou(), $article->getCouleur(), $article->getTaille());
                $panier = Panier::construireDepuisTableau(["mailClient" => $idClient, "idArticle" => $idArticle, "quantite" => $quantite]);
                $lignes[] = $panier;
            }
            foreach ($lignes as $ligne) {
                if ((new PanierRepository())->contientArticle($idClient, $ligne->getIdArticle())) {
                    $ligneExistante = (new PanierRepository())->selectPanierFromClientEtArticle($idClient, $ligne->getIdArticle());
                    (new PanierRepository())->modifierQuantite($idClient, $ligne->getIdArticle(), $ligneExistante->getQuantite() + $ligne->getQuantite());
                } else {
                    (new PanierRepository())->save($ligne);
                }
            }
            self::vider();
        }
    }
}