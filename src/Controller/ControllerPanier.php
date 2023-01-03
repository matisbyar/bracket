<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\Repository\PanierRepository;

class ControllerPanier extends GenericController
{
    public static function basket(): void
    {
        if (ConnexionClient::estConnecte()) {
            $panier = (new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte());
            var_dump($panier);
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour accéder à votre panier.");
            self::redirige("?action=home");
        }
    }

    public static function add(): void
    {
        if (ConnexionClient::estConnecte()) {
            $panier = Panier::construireDepuisTableau((new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte()));
            (new PanierRepository())->save($panier);
            MessageFlash::ajouter("success", "Le produit a bien été ajouté au panier.");
            self::redirige("?action=home");
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour ajouter un produit au panier.");
            self::redirige("?action=home");
        }
    }

       public static function delete(): void
        {
            if (ConnexionClient::estConnecte()) {
                (new PanierRepository)->deleteElementFromPanier(ConnexionClient::getLoginUtilisateurConnecte(), $_REQUEST["id"]);
                MessageFlash::ajouter("success", "Le produit a bien été supprimé du panier.");
                self::redirige("?action=home");
            } else {
                MessageFlash::ajouter("warning", "Vous devez être connecté pour supprimer un produit du panier.");
                self::redirige("?action=home");
            }
        }
}