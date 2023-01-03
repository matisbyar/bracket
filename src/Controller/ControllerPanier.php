<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
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
}