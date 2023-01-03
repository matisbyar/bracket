<?php

namespace App\Bracket\Lib;

use App\Bracket\Model\DataObject\Article;
use App\Bracket\Model\HTTP\Session;

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
        $panier[] = ["article" => $article, "quantite" => $quantite];
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
            if ($articlePanier["article"]->getIdBijou() === $article->getIdBijou()) return true;
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
            $articles[] = $articlePanier["article"];
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
            $quantites[] = $articlePanier["quantite"];
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
            $articlesQuantites[] = ["article" => $articlePanier["article"], "quantite" => $articlePanier["quantite"]];
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
        $nombreTotal = 0;
        foreach ($panier as $articlePanier) {
            $nombreTotal += $articlePanier["quantite"];
        }
        return $nombreTotal;
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
            $prixTotal += $articlePanier["article"]->getPrix() * $articlePanier["quantite"];
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
        $nouveauPanier = [];
        foreach ($panier as $articlePanier) {
            if ($articlePanier["article"]->getIdBijou() !== $article->getIdBijou()) $nouveauPanier[] = $articlePanier;
        }
        Session::getInstance()->enregistrer(self::$clePanier, $nouveauPanier);
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
        $nouveauPanier = [];
        foreach ($panier as $articlePanier) {
            if ($articlePanier["article"]->getIdBijou() === $article->getIdBijou()) {
                $articlePanier["quantite"] = $quantite;
            }
            $nouveauPanier[] = $articlePanier;
        }
        Session::getInstance()->enregistrer(self::$clePanier, $nouveauPanier);
    }

}