<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\MessageFlash;

class GenericController
{

    protected static function afficheVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    protected static function redirige(string $chemin): void
    {
        header("Location: $chemin");
        exit();
    }

    public static function login(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Connexion", "cheminVueBody" => "client/login.php"]);
    }

    public static function error(string $action): void
    {
        MessageFlash::ajouter("danger", "L'action " . $action . " est impossible.");
    }
}