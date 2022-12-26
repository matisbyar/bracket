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
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Compte", "cheminVueBody" => "client/detail.php"]);
    }

    public static function readAll(): void
    {
        if(ConnexionUtilisateur::estAdministrateur()){
            $clients = (new ClientRepository())->readAll();
            self::afficheVue("view.php", ["clients" => $clients, "pagetitle" => "Bracket - Clients", "cheminVueBody" => "client/list.php"]);
        }else{
            MessageFlash::ajouter("danger", "Vous n'avez pas accès à cette page");
            self::redirige("?action=account&controller=client");
        }
    }

    public static function update(): void
    {
        $client = (new ClientRepository())->read($_GET['email']);
        if ($client->getMail()==ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
            self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modifier client", "cheminVueBody" => "client/update.php"]);
        }else{
            MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte");
            self::redirige("?action=account&controller=client");
        }
    }

    public static function updateAdmin() : void
    {
        $client = (new ClientRepository())->read($_GET["email"]);
        if(ConnexionUtilisateur::estAdministrateur()){
            self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modifier client", "cheminVueBody" => "client/updateAdmin.php"]);
        }else{
            MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte");
        }
    }

    public static function login(): void
    {
        self::afficheVue("view.php", ["pagetitle" => "Bracket - Connection", "cheminVueBody" => "client/login.php"]);
    }

    public static function account(): void
    {
        $client = (new ClientRepository())->read(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Compte", "cheminVueBody" => "client/account.php"]);
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
                MessageFlash::ajouter("warning", "Le client existe deja");
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

    public static function updated() : void 
    {
        $clientUpdate = Client::construireDepuisFormulaire($_POST);
        $clientRepository = new ClientRepository();
        $client = $clientRepository->read($clientUpdate->getMail());
        if(!ConnexionUtilisateur::estUtilisateur($clientUpdate->getMail())){
            MessageFlash::ajouter("warning", "Vous n'avez pas les droits pour modifier ce compte");
            self::redirige("?action=update&controller=client&email=".$clientUpdate->getMail());
        }else if(MotDePasse::verifier($_POST['password'], $client->getMdpHache())){
            $clientRepository->update($clientUpdate);
            MessageFlash::ajouter("success", "Votre compte à bien été modifié");
            self::redirige("?action=account&controller=client");
        }else{
            MessageFlash::ajouter("warning", "Le mot de passe est incorrect");
            self::redirige("?action=update&controller=client&email=".$clientUpdate->getMail());
        }
    }

    public static function updatedAdmin() : void 
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->read($_POST['mail']);
        $clientUpdate = Client::construireDepuisFormulaireAdmin($_POST, $client->getMdpHache());
        $clientRepository->update($clientUpdate);
        MessageFlash::ajouter("success", "Le compte a bien été modifié");
        self::redirige("?action=readAll&controller=client");
    }

    public static function updatePassword() : void{
        $client = (new ClientRepository())->read(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        if($client->getMail()!=ConnexionUtilisateur::getLoginUtilisateurConnecte()){
            MessageFlash::ajouter("danger", "Vous n'avez pas le droit de modifier ce compte");
            self::redirige("?action=account&controller=client");
        }else if ($client != null) {
            self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Bracket - Modification", "cheminVueBody" => "client/updatePassword.php"]);
        }
    }

    public static function updatedPassword(): void {
        $oldPassword = $_POST["oldPassword"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $client = (new ClientRepository)->read(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        if(!strcmp($password,$password2)){
            MessageFlash::ajouter("warning", "Les mots de passe rentrés sont différents");
            self::redirige("?action=updatePassword&controller=client");
        }else if (!MotDePasse::verifier($oldPassword,$client->getMdpHache())){
            MessageFlash::ajouter("warning", "Le mot de passe actuel n'est pas correct");
            self::redirige("?action=updatePassword&controller=client");
        }else{
            MessageFlash::ajouter("success", "Le mot de passe a bien été modifié");
            $client->setPassword(MotDePasse::hacher($password));
            (new ClientRepository)->update($client);
            self::redirige("?action=account&controller=client");
        }
    }
}