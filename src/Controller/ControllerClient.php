<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionUtilisateur;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\MotDePasse;
use App\Bracket\Model\Repository\ClientRepository;

class ControllerClient
{
    public static function readAll(): void
    {
        $clients = (new ClientRepository())->selectAll();
        self::afficheVue("view.php", ["clients" => $clients, "pagetitle" => "Liste des clients", "cheminVueBody" => "client/list.php"]);
    }

    private static function afficheVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres);               // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue";    // Charge la vue
    }

    public static function read(): void
    {
        $client = (new ClientRepository())->select($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Détail d'un client", "cheminVueBody" => "client/detail.php"]);
    }

    public static function update(): void
    {
        $client = (new ClientRepository())->select($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Modifier un client", "cheminVueBody" => "client/update.php"]);
    }

    public static function connecter()
    {
        $utilisateur = (new ClientRepository())->select($_POST['login']);
        if ($utilisateur == null) {
            MessageFlash::ajouter("Danger","L'identifiant est incorrect");
        } else {
            if ($_POST['motdepasse'] == MotDePasse::verifier($_POST['motdepasse'], $utilisateur->getMdpHache())) {
                ConnexionUtilisateur::connecter($utilisateur->getMail());
                header('Location: frontController.php?controller=utilisateur&action=read&login=' . rawurlencode($utilisateur->getMail()));
            } else {
                MessageFlash::ajouter("Danger","Le mot de passe est incorrect");
            }
        }
    }
}