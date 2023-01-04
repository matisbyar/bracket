<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\HTTP\Session;
use App\Bracket\Model\Repository\CommandeRepository;

class ControllerCommande extends GenericController {

    public static function readAll() {
        $mail = ConnexionClient::getLoginUtilisateurConnecte();
        $commandes = (new CommandeRepository())->getCommandeParId($mail);
        self::afficheVue("view.php", ["commandes" => $commandes, "pagetitle" => "Bracket - Mes commandes", "cheminVueBody" => "commande/list.php"]);
    }
}
{

}