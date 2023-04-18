<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\Repository\CommandeRepository;
use App\Bracket\Model\Repository\PanierRepository;

class ControllerCommande extends GenericController
{

    public static function readAll()
    {
        if (ConnexionClient::estConnecte()) {
            $mail = ConnexionClient::getLoginUtilisateurConnecte();
            $commandes = (new CommandeRepository())->getCommandeParIdClient($mail);
            if (sizeof($commandes) > 0) self::afficheVue("view.php", ["commandes" => $commandes, "pagetitle" => "Bracket - Mes commandes", "cheminVueBody" => "commande/list.php"]);
            else {
                MessageFlash::ajouter("info", "Vous n'avez pas encore passé aucune commande.");
                self::redirige("index.php?controller=client&action=account");
            }
        } else {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour accéder à cette page.");
            self::redirige("index.php?controller=client&action=login");
        }
    }

    public static function read()
    {
        if (ConnexionClient::estConnecte()) {
            if (isset($_GET["id"])) {
                if ((new CommandeRepository())->commandeExiste($_GET['id'])) {
                    $commande = (new CommandeRepository())->getCommandeParId($_GET["id"]);
                    self::afficheVue("view.php", ["commande" => $commande, "pagetitle" => "Bracket - Détail de la commande", "cheminVueBody" => "commande/detail.php"]);
                } else {
                    MessageFlash::ajouter("danger", "La commande n'existe pas.");
                    self::redirige("index.php?controller=commande&action=readAll");
                }
            } else {
                MessageFlash::ajouter("danger", "La commande n'existe pas.");
                self::readAll();
            }
        } else {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour accéder à cette page.");
            self::redirige("index.php?controller=client&action=login");
        }
    }

    public static function commander(): void
    {
        $mail = ConnexionClient::getLoginUtilisateurConnecte();
        if ($mail == null) {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour effectuer une commande.");
            self::redirige("index.php?controller=client&action=login");
        } else {
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
    }

    public static function updateStatutCommande(string $statut = ""): void
    {
        if ($statut != "") {
            if (ConnexionClient::estAdministrateur()) {
                if (isset($_GET["id"])) {
                    if ((new CommandeRepository())->commandeExiste($_GET['id'])) {
                        (new CommandeRepository())->updateStatut($_GET["id"], $statut);
                        MessageFlash::ajouter("success", "Statut de la commande modifié avec succès.");
                        self::redirige("index.php?controller=commande&action=read&id=" . $_GET["id"]);
                    } else {
                        MessageFlash::ajouter("danger", "La commande n'existe pas.");
                        self::redirige("index.php?controller=commande&action=readAll");
                    }
                } else {
                    MessageFlash::ajouter("danger", "La commande n'existe pas.");
                    self::redirige("index.php?controller=commande&action=readAll");
                }
            } else {
                MessageFlash::ajouter("warning", "Vous n'avez pas le droit de faire cette action.");
                self::home();
            }
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas le droit de faire cette action.");
            self::home();
        }
    }

    public static function validerCommande(): void
    {
        self::updateStatutCommande("validée");
        MessageFlash::ajouter("success", "Commande validée.");
        self::home();
    }

    public static function annulerCommande(): void
    {
        self::updateStatutCommande("annulée");
        MessageFlash::ajouter("success", "Commande annulée.");
        self::home();
    }


    public static function recommander(): void
    {
        if (isset($_GET["id"])) {
            if ((new CommandeRepository())->commandeExiste($_GET["id"])) {
                $commande = (new CommandeRepository())->getCommandeParId($_GET["id"]);
                foreach ($commande->getArticles() as $article) {
                    $panier = Panier::construireDepuisTableau(
                        array(
                            "mailClient" => ConnexionClient::getLoginUtilisateurConnecte(),
                            "idArticle" => $article->getIdArticle(),
                            "quantite" => (new CommandeRepository())->getQuantiteProduitCommande($commande->getId(), $article->getIdArticle())
                        )
                    );
                    (new PanierRepository())->create($panier);
                }
                MessageFlash::ajouter("success", "Commande ajoutée dans votre panier.");
                ControllerPanier::basket();
            } else {
                MessageFlash::ajouter("danger", "La commande n'existe pas.");
                self::home();
            }
        } else {
            MessageFlash::ajouter("danger", "La commande n'existe pas.");
            self::home();
        }
    }

    public static function commande(): void
    {
        if (ConnexionClient::estAdministrateur()) {
            $commandes = (new CommandeRepository())->getCommandes();
            self::afficheVue("view.php", ["commandes" => $commandes, "pagetitle" => "Bracket - Commandes", "cheminVueBody" => "commande/list.php"]);
        } else {
            MessageFlash::ajouter("warning", "Vous n'avez pas le droit de faire cette action.");
            self::home();
        }
    }


}