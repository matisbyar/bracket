<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Commande;
use App\Bracket\Model\Repository\ClientRepository;
use App\Bracket\Model\Repository\CommandeRepository;
use App\Bracket\Model\Repository\PanierRepository;

class ControllerCommande extends GenericController
{

    public static function readAll()
    {
        $mail = ConnexionClient::getLoginUtilisateurConnecte();
        $commandes = (new CommandeRepository())->getCommandeParIdClient($mail);
        self::afficheVue("view.php", ["commandes" => $commandes, "pagetitle" => "Bracket - Mes commandes", "cheminVueBody" => "commande/list.php"]);
    }

    public static function read()
    {
        $commande = (new CommandeRepository())->getCommandeParId($_GET["id"]);
        self::afficheVue("view.php", ["commande" => $commande, "pagetitle" => "Bracket - Détail de la commande", "cheminVueBody" => "commande/detail.php"]);
    }

    public static function commander(): void
    {
        $mail = ConnexionClient::getLoginUtilisateurConnecte();
        $panier = (new PanierRepository())->selectPanierFromClient($mail);

        if ($panier != null) {
            (new CommandeRepository())->ajouterCommande($panier);
            MessageFlash::ajouter("success", "Commande effectuée avec succès.");
            (new PanierRepository())->viderPanierParClient($mail);
        } else {
            MessageFlash::ajouter("danger", "Votre panier est vide.");
        }
        self::home();
    }

    public static function updateStatutCommande(string $statut): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $commande = (new CommandeRepository)->select($_POST["id"]);
            $commande->setStatut($statut);
            (new CommandeRepository)->update($commande);
        } else {
            MessageFlash::ajouter("warning", "Erreur de mises à jour.");
            self::redirige("?action=home");
        }
    }

    public static function validerCommande(): void{
        self::updateStatutCommande("validée.");
        MessageFlash::ajouter("success", "Commande validée.");
        self::home();

    }

    public static function annulerCommande(): void{
        self::updateStatutCommande("annulée.");
        MessageFlash::ajouter("success", "Commande annulée.");
        self::home();
    }


}