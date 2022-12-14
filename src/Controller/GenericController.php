<?php

namespace App\Bracket\Controller;

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

    public static function connexion(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Connexion", "cheminVueBody" => "client/login.php"]);
    }
}