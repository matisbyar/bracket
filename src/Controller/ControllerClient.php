<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\MotDePasse;
use App\Bracket\Lib\PanierSession;
use App\Bracket\Lib\VerificationEmail;
use App\Bracket\Model\DataObject\Client;
use App\Bracket\Model\Repository\ClientRepository;

class ControllerClient extends GenericController
{

    /**
     * Crée un client
     */
    public static function create(): void
    {
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['naissance']) && isset($_POST['mail'])) {
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                MessageFlash::ajouter("danger", "L'adresse mail n'est pas valide.");
                self::afficheVue('view.php', ['nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'date' => $_POST['naissance'], 'email' => $_POST['mail'], 'adresse' => $_POST['adresse'], 'pagetitle' => 'Bracket - Connexion/Inscription,', 'cheminVueBody' => 'client/login.php']);
                exit();
            }
            if (!MotDePasse::motDePasseValide($_POST['password'])) {
                MessageFlash::ajouter("warning", "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.");
                self::afficheVue('view.php', ['nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'date' => $_POST['naissance'], 'email' => $_POST['mail'], 'adresse' => $_POST['adresse'], 'pagetitle' => 'Login', 'cheminVueBody' => 'client/login.php']);
                exit();

            } else if ($_POST['password'] == $_POST['password2']) {
                $client = Client::construireDepuisFormulaire($_POST);
                $clients = (new ClientRepository())->selectAll();
                foreach ($clients as $c) {
                    if ($c->getMail() == $_POST['mail']) {
                        MessageFlash::ajouter("warning", "Le client existe déjà.");
                        self::afficheVue('view.php', ['nom' => $_POST['nom'], 'prenom' => $_POST['prenom'], 'naissance' => $_POST['naissance'], 'mail' => $_POST['mail'], 'adresse' => $_POST['adresse'], 'pagetitle' => 'Login', 'cheminVueBody' => 'client/login.php']);
                        exit();
                    }
                }
                (new ClientRepository())->create($client);
                MessageFlash::ajouter("success", "Votre compte a été créé. Vous allez par ailleurs recevoir un courriel pour valider votre adresse mail.");
                VerificationEmail::envoiEmailValidation($client);
                self::home();
            } else {
                if (!ConnexionClient::estAdministrateur() && $_REQUEST['estAdmin']) MessageFlash::ajouter("warning", "Vous n'avez pas le droit de créer un administrateur. Le compte a été créé sans droits administrateur.");
                $client = Client::construireDepuisFormulaire($_REQUEST);
                (new ClientRepository())->create($client);
                VerificationEmail::envoiEmailValidation($client);

                MessageFlash::ajouter("success", "Votre compte a été créé.");
                self::redirige("?controller=client&action=readAll");
            }
        } else {
            MessageFlash::ajouter("warning", "Tous les champs doivent être remplis.");
            self::login();
        }
    }

    /**
     * Renvoie sur le détail d'un client
     */
    public static function read(): void
    {
        $client = (new ClientRepository())->select($_GET['email']);
        if ($client != null && ConnexionClient::estAdministrateur()) {
            self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Compte", "cheminVueBody" => "client/detail.php"]);
        } else {
            MessageFlash::ajouter("danger", "Vous n'avez pas accès à cette page");
            self::redirige("?action=account&controller=client");
        }
    }

    /**
     * Renvoie sur la liste de tous les clients
     */
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

    /**
     * Renvoie vers le formulaire de modification d'un client
     */
    public static function update(): void
    {
        if (ConnexionClient::estConnecte()) {
            $client = (new ClientRepository())->select($_GET['email']);

            if ($client == null) {
                MessageFlash::ajouter("danger", "Le client n'existe pas.");
                self::redirige("?action=readAll&controller=client");
            } else if (ConnexionClient::estUtilisateur($_GET['email']) || ConnexionClient::estAdministrateur()) {
                self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modifier un profil", "cheminVueBody" => "client/update.php"]);
            } else {
                MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte.");
                self::redirige("?action=account&controller=client");
            }
        } else {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour accéder à cette page.");
            self::redirige("?action=login&controller=client");
        }
    }

    /**
     * Methode qui permet de mettre à jour un client
     */
    public static function updated(): void
    {
        if (ConnexionClient::estConnecte() && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['naissance']) && isset($_POST['mail']) && isset($_POST['adresse'])) {
            $mail = $_POST['email'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $naissance = $_POST['naissance'];
            $adresse = $_POST['adresse'];
            $estAdmin = $_POST['estAdmin'] ?? "";
            $client = (new ClientRepository())->select($mail);

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
                self::home();
            }
        } else {
            MessageFlash::ajouter("danger", "Tous les champs doivent être remplis.");
            self::redirige(ConnexionClient::estConnecte() ? "?controller=client&action=update&email=" . $_POST['email'] : "?controller=client&action=login");
        }
    }

    /**
     * Renvoie vers la page de modification du mot de passe d'un client
     */
    public static function updatePassword(): void
    {
        if (ConnexionClient::estConnecte()) {
            $client = (new ClientRepository())->select(ConnexionClient::getLoginUtilisateurConnecte());

            if ($client->getMail() != ConnexionClient::getLoginUtilisateurConnecte()) {
                MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte.");
                self::redirige("?action=account&controller=client");
            } else if ($client != null) {
                self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modification", "cheminVueBody" => "client/updatePassword.php"]);
            } else {
                MessageFlash::ajouter("danger", "Le client n'existe pas");
                self::account();
            }
        } else {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour accéder à cette page.");
            self::redirige("?action=login&controller=client");
        }
    }

    /**
     * Met à jour le mot de passe d'un client
     */
    public static function updatedPassword(): void
    {
        if (ConnexionClient::estConnecte() && isset($_POST['oldPassword']) && isset($_POST['password']) && isset($_POST['password2'])) {

            $oldPassword = $_POST["oldPassword"];
            $newPassword = $_POST["password"];
            $newPasswordConfirmation = $_POST["password2"];

            $client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());
            if ($newPassword !== $newPasswordConfirmation) {
                MessageFlash::ajouter("warning", "Les mots de passe entrés doivent être identiques.");
                self::redirige("?action=updatePassword&controller=client");
            } else if (!MotDePasse::verifier($oldPassword, $client->getMdpHache())) {
                MessageFlash::ajouter("warning", "Le mot de passe actuel est erroné.");
                self::redirige("?action=updatePassword&controller=client");
            } else {
                MessageFlash::ajouter("success", "Le mot de passe a bien été modifié.");
                $client->setPassword(MotDePasse::hacher($newPassword));
                (new ClientRepository())->update($client);
                self::account();
            }
        } else {
            MessageFlash::ajouter("danger", "Tous les champs doivent être remplis.");
            self::redirige("?action=updatePassword&controller=client");
        }
    }

    /**
     * Renvoie vers la page de connexion
     */
    public static function login(): void
    {
        if (!ConnexionClient::estConnecte()) {
            self::afficheVue("view.php", ["pagetitle" => "Bracket - Connexion/Inscription", "cheminVueBody" => "client/login.php"]);
        } else {
            self::account();
        }
    }

    /**
     * Renvoie sur la page du compte client
     */
    public static function account(): void
    {
        if (ConnexionClient::estConnecte()) {
            $client = (new ClientRepository())->select(ConnexionClient::getLoginUtilisateurConnecte());
            if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Compte", "cheminVueBody" => "client/account.php"]);
        } else self::login();
    }

    /**
     * Connecte un client et ajoute son panier de session à son panier en base de données
     */
    public static function connecter(): void
    {
        if (!ConnexionClient::estConnecte()) {
            if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
                $client = (new ClientRepository())->select($_POST['email']);
                if ($client == null) {
                    MessageFlash::ajouter("Danger", "L'identifiant est incorrect.");
                    self::login();
                } else {
                    if ($_POST['password'] == MotDePasse::verifier($_POST['password'], $client->getMdpHache())) {
                        ConnexionClient::connecter($client->getMail());
                        PanierSession::migrerVersCompte();
                        MessageFlash::ajouter("success", "Bienvenue, " . $client->getPrenom() . ".");
                        self::redirige("?action=home");
                    } else {
                        MessageFlash::ajouter("Danger", "Le mot de passe ou l'identifiant est incorrect.");
                        self::login();
                    }
                }
            } else {
                MessageFlash::ajouter("danger", "Tous les champs doivent être remplis.");
                self::login();
            }
        } else {
            MessageFlash::ajouter("info", "Vous êtes déjà connecté.");
            self::home();
        }
    }

    /**
     * Déconnecte le client connecté
     */
    public static function logout(): void
    {
        if (ConnexionClient::estConnecte()) {
            ConnexionClient::deconnecter();
            MessageFlash::ajouter("success", "Vous êtes bien déconnecté(e).");
        } else {
            MessageFlash::ajouter("info", "Vous n'êtes pas connecté(e).");
        }
        self::home();
    }

    /**
     * Effectue la vérification de l'email d'un client. Valide ou non, selon le cas
     */
    public static function validerEmail(): void
    {
        if (isset($_REQUEST['login']) && isset($_REQUEST['nonce'])) {
            if (ConnexionClient::estConnecte() && ConnexionClient::getLoginUtilisateurConnecte() == $_REQUEST['login']) {
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
            }
        } else {
            MessageFlash::ajouter("danger", "Le lien de validation est incorrect.");
        }
        self::home();
    }

    /**
     * Renvoie vers la page de l'administration des clients
     */
    public static function admin(): void
    {
        if (!ConnexionClient::estAdministrateur()) {
            MessageFlash::ajouter("danger", "Vous n'avez pas accès à cette page.");
            self::home();
        } else {
            self::afficheVue("view.php", ["pagetitle" => "Administration", "cheminVueBody" => "admin.php"]);
        }
    }
}