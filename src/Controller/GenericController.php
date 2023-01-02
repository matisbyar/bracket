<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\MessageFlash;

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
     * Methode qui permet de renvoyé sur la page de connexion
     * @return void
     */
    public static function login(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Connexion", "cheminVueBody" => "client/login.php"]);
    }

    public static function aPropos(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "À propos", "cheminVueBody" => "a-propos.php"]);
    }

    /**
     * Methode qui permet d'afficher une error
     * @return void
     */
    public static function error(string $action): void
    {
        MessageFlash::ajouter("danger", "L'action " . $action . " est impossible.");
    }
}