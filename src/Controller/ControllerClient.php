<?php
namespace App\Bracket\Controller;
use App\Bracket\Model\DataObject\Client;
use App\Bracket\Model\Repository\AbstractRepository;
use App\Bracket\Model\Repository\ClientRepository;

class ControllerClient {
    public static function readAll() : void {
        $clients = (new ClientRepository())->selectAll();
        self::afficheVue("view.php", ["clients" => $clients, "pagetitle" => "Liste des clients", "cheminVueBody" => "client/list.php"]);
    }

    public static function read() : void {
        $client = (new ClientRepository())->select($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Détail d'un client", "cheminVueBody" => "client/detail.php"]);
    }

    public static function update() : void {
        $client = (new ClientRepository())->select($_GET['email']);
        if ($client != null) self::afficheVue("view.php", ["client" => $client, "pagetitle" => "Modifier un client", "cheminVueBody" => "client/update.php"]);
    }

    private static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

}