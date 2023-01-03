<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\Repository\ClientRepository;
use App\Bracket\Lib\Panier;

$client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());

var_dump(Panier::getNbProduits());

?>


