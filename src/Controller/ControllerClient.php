<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionUtilisateur;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\MotDePasse;
use App\Bracket\Model\Repository\ClientRepository;

class ControllerClient extends GenericController
{
    public static function error(string $action): void
    {
        MessageFlash::ajouter("danger", "L'action " . $action . " est impossible.");
    }

    public static function create(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Créer un compte", "cheminVueBody" => "client/create"]);
    }

    public static function read(): void
    {
        $client = (new ClientRepository())->read($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Détail d'un client", "cheminVueBody" => "client/detail.php"]);
    }

    public static function readAll(): void
    {
        $clients = (new ClientRepository())->readAll();
        self::afficheVue("view.php", ["clients" => $clients, "pagetitle" => "Liste des clients", "cheminVueBody" => "client/list.php"]);
    }

    public static function update(): void
    {
        $client = (new ClientRepository())->read($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Modifier un client", "cheminVueBody" => "client/update.php"]);
    }

    public static function connecter()
    {
        $utilisateur = (new ClientRepository())->read($_POST['login']);
        if ($utilisateur == null) {
            MessageFlash::ajouter("Danger", "L'identifiant est incorrect");
        } else {
            if ($_POST['motdepasse'] == MotDePasse::verifier($_POST['motdepasse'], $utilisateur->getMdpHache())) {
                ConnexionUtilisateur::connecter($utilisateur->getMail());
                self::redirige("home.php");
            } else {
                MessageFlash::ajouter("Danger", "Le mot de passe est incorrect");
            }
        }
    }

    public static function deconnecter()
    {
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success", "Vous êtes déconnecté");
        self::redirige("?action=home");
    }
}