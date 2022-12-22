<?php
//test
namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionUtilisateur;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\MotDePasse;
use App\Bracket\Model\DataObject\Client;
use App\Bracket\Model\Repository\ClientRepository;

class ControllerClient extends GenericController
{
    public static function error(string $action): void
    {
        MessageFlash::ajouter("danger", "L'action " . $action . " est impossible.");
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

    public static function login(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Se connecter", "cheminVueBody" => "client/login.php"]);
    }

    public static function account(): void
    {
        $client = (new ClientRepository())->read($_SESSION['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Mon compte", "cheminVueBody" => "client/account.php"]);
    }

    public static function connecter(): void
    {
        $client = (new ClientRepository())->read($_POST['login']);
        if ($client == null) {
            MessageFlash::ajouter("Danger", "L'identifiant est incorrect");
            self::redirige("?action=login&controller=client");
        } else {
            if ($_POST['motdepasse'] == MotDePasse::verifier($_POST['motdepasse'], $client->getMdpHache())) {
                ConnexionUtilisateur::connecter($client->getMail());
                MessageFlash::ajouter("success", "Vous êtes connecté");
                self::redirige("?action=home");
            } else {
                MessageFlash::ajouter("Danger", "Le mot de passe est incorrect");
                self::redirige("?action=login&controller=client");
            }
        }
    }

    public static function creer(): void
    {
        if ($_POST['password'] == $_POST['password2']) {
            $client = Client::construireDepuisFormulaire($_POST);
            if ($client == null) {
                MessageFlash::ajouter("warning", "L'client existe deja");
                self::redirige("?action=login&controller=client");
            } else {
                $clientRepository = new ClientRepository();
                $clientRepository->create($client);
                MessageFlash::ajouter("success", "Votre compte à bien été créé");
                self::redirige("?action=readAll&controller=produit");
            }
        } else {
            MessageFlash::ajouter("warning", "Les mots de passe ne sont pas identique");
            self::redirige("?action=login&controller=client");
        }
    }

    public static function logout(): void
    {
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success", "Vous êtes déconnecté");
        self::redirige("?action=home");
    }
}