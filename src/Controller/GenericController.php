<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\Repository\ProduitRepository;

class GenericController
{

    /**
     * Methode qui permet d'afficher une vue
     * @param string $cheminVue
     * @param array $parametres
     * @return void
     */
    protected static function afficheVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    /**
     * Methode qui permet d'afficher une vue avec un message flash
     * @param string $chemin
     * @return void
     */
    protected static function redirige(string $chemin): void
    {
        header("Location: $chemin");
        exit();
    }

    /**
     * Methode qui permet d'afficher la page d'accueil
     * @return void
     */
    public static function home(): void
    {
        $produits = (new ProduitRepository())->selectAll();
        shuffle($produits);
        $produits = array_slice($produits, 0, 8);
        self::afficheVue("view.php", ["produits" => $produits, "produitALaUne" => $produits[0], "pagetitle" => "Bracket", "cheminVueBody" => "home.php"]);
    }

    /**
     * Renvoie sur la page de connexion
     * @return void
     */
    public static function login(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Bracket - Connexion/Inscription", "cheminVueBody" => "client/login.php"]);
    }

    public static function aPropos(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Bracket - À propos", "cheminVueBody" => "apropos.php"]);
    }

    public static function contact(): void
    {
        self::aPropos();
    }

    public static function plan(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Bracket - Plan", "cheminVueBody" => "plan.php"]);
    }

    /**
     * Methode qui permet d'afficher une error
     * @return void
     */
    public static function error(string $action = "", string $message = ""): void
    {
        MessageFlash::ajouter("danger", $action === "" ? $message : "L'action " . $action . " est impossible.");
        self::redirige("?action=home");
    }
}