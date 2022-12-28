<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\MotDePasse;
use App\Bracket\Lib\VerificationEmail;
use App\Bracket\Model\DataObject\Client;
use App\Bracket\Model\Repository\ClientRepository;

class ControllerClient extends GenericController
{

    public static function create(): void
    {
        if ($_REQUEST['mdp'] != $_REQUEST['mdp2']) {
            MessageFlash::ajouter("danger", "Les mots de passe ne correspondent pas.");
            self::redirige("?controller=client&action=create");
        } else {
            if (!ConnexionClient::estAdministrateur() && $_REQUEST['estAdmin']) MessageFlash::ajouter("warning", "Vous n'avez pas le droit de créer un administrateur. Le compte a été créé sans droits administrateur.");
            $client = Client::construireDepuisFormulaire($_REQUEST);
            (new ClientRepository())->save($client);
            VerificationEmail::envoiEmailValidation($client);

            MessageFlash::ajouter("success", "Votre compte a été créé.");
            self::redirige("?controller=client&action=readAll");
        }
    }

    public static function read(): void
    {
        $client = (new ClientRepository())->select($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Compte", "cheminVueBody" => "client/detail.php"]);
    }

    public static function readAll(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $clients = (new ClientRepository())->selectAll();
            self::afficheVue("view.php", ["clients" => $clients, "pagetitle" => "Bracket - Clients", "cheminVueBody" => "client/list.php"]);
        } else {
            MessageFlash::ajouter("danger", "Vous n'avez pas accès à cette page");
            self::redirige("?action=account&controller=client");
        }
    }

    public static function update(): void
    {
        $client = (new ClientRepository())->select($_GET['email']);

        if ($client == null) {
            MessageFlash::ajouter("danger", "Le client n'existe pas");
            self::redirige("?action=readAll&controller=client");
        } else if (ConnexionClient::estUtilisateur($_GET['email']) || ConnexionClient::estAdministrateur()) {
            self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modifier client", "cheminVueBody" => "client/update.php"]);
        } else {
            MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte.");
            self::redirige("?action=account&controller=client");
        }
    }

    public static function updated(): void
    {
        $mail = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $naissance = $_POST['naissance'];
        $adresse = $_POST['adresse'];
        $estAdmin = $_POST['estAdmin'] ?? "";
        $client = (new CLientRepository())->select($mail);
        if (!ConnexionClient::estUtilisateur($mail) && !ConnexionClient::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Hop-hop-hop ! N'allez pas trop loin !");
            self::redirige("?controller=utilisateur&action=readAll");
        } else if ($client == null) {
            MessageFlash::ajouter("danger", "L'utilisateur n'existe pas.");
            self::redirige("index.php?controleur=utilisateur&action=readAll");
        } else {
            // Mise à jour
            $client->setNom($nom);
            $client->setPrenom($prenom);
            $client->setDateNaissance($naissance);
            $client->setAdresse($adresse);
            $client->setMailValide(false);
            $client->setNonce(MotDePasse::genererChaineAleatoire());
            $client->setEstAdmin(ConnexionClient::estAdministrateur() ? $estAdmin : false);

            // Validation de l'email
            if (!ConnexionClient::estAdministrateur() || ConnexionClient::estUtilisateur($mail)) {
                VerificationEmail::envoiEmailValidation($client);
            }

            (new ClientRepository())->update($client);
            MessageFlash::ajouter("success", "Votre compte a été mis à jour.");
            self::redirige("?controller=client&action=readAll");
        }
    }

    public static function updatePassword(): void
    {
        $client = (new ClientRepository())->select(ConnexionClient::getLoginUtilisateurConnecte());

        if ($client->getMail() != ConnexionClient::getLoginUtilisateurConnecte()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte.");
            self::redirige("?action=account&controller=client");
        } else if ($client != null) {
            self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modification", "cheminVueBody" => "client/updatePassword.php"]);
        }
    }

    public static function updatedPassword(): void
    {
        $oldPassword = $_POST["oldPassword"];
        $newPassword = $_POST["password"];
        $newPasswordConfirmation = $_POST["password2"];

        $client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());
        if (!strcmp($newPassword, $newPasswordConfirmation)) {
            MessageFlash::ajouter("warning", "Les mots de passe entrés doivent être identiques.");
            self::redirige("?action=updatePassword&controller=client");
        } else if (!MotDePasse::verifier($oldPassword, $client->getMdpHache())) {
            MessageFlash::ajouter("warning", "Le mot de passe actuel est erroné.");
            self::redirige("?action=updatePassword&controller=client");
        } else {
            $client->setPassword(MotDePasse::hacher($newPassword));

            (new ClientRepository)->update($client);
            MessageFlash::ajouter("success", "Le mot de passe a bien été modifié");
            self::redirige("?action=account&controller=client");
        }
    }

    public static function login(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Bracket - Connexion", "cheminVueBody" => "client/login.php"]);
    }

    public static function account(): void
    {
        $client = (new ClientRepository())->select(ConnexionClient::getLoginUtilisateurConnecte());
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Compte", "cheminVueBody" => "client/account.php"]);
    }

    public static function connecter(): void
    {
        $client = (new ClientRepository())->select($_POST['login']);
        if ($client == null) {
            MessageFlash::ajouter("Danger", "L'identifiant est incorrect");
            self::redirige("?action=login&controller=client");
        } else {
            if ($_POST['password'] == MotDePasse::verifier($_POST['password'], $client->getMdpHache())) {
                ConnexionClient::connecter($client->getMail());
                MessageFlash::ajouter("success", "Bienvenue, " . $client->getPrenom() . ".");
                self::redirige("?action=home");
            } else {
                MessageFlash::ajouter("Danger", "Le mot de passe ou l'identifiant est incorrect.");
                self::redirige("?action=login&controller=client");
            }
        }
    }

    public static function logout(): void
    {
        ConnexionClient::deconnecter();
        MessageFlash::ajouter("success", "Vous êtes bien déconnecté(e).");
        self::redirige("?action=home");
    }

    public static function validerEmail(): void
    {
        if (isset($_REQUEST['login']) && isset($_REQUEST['nonce'])) {
            $login = $_REQUEST['login'];
            $nonce = $_REQUEST['nonce'];
            $client = (new ClientRepository())->select($login);
            if ($client == null) {
                MessageFlash::ajouter("danger", "Le compte n'existe pas.");
                self::redirige("?controller=client&action=readAll");
            }
            if (!VerificationEmail::traiterEmailValidation($login, $nonce)) {
                MessageFlash::ajouter("danger", "Le lien de validation est incorrect.");
            } else {
                MessageFlash::ajouter("success", "Votre compte a été validé.");
            }
        } else {
            MessageFlash::ajouter("danger", "Le lien de validation est incorrect.");
        }
        self::redirige("?controller=client&action=readAll");
    }
}