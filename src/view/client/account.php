<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MotDePasse;
use App\Bracket\Model\Repository\ClientRepository;
use App\Bracket\Model\Repository\CommandeRepository;


$client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());
?>

<div class="admin-title">
        <h1>Mon Compte</h1>
        <p>Psst ! Retrouvez sur cette page, toutes les fonctions vous concernant. </p>
    </div>
<?php
echo "<h2 class='InfoAccount'> " . htmlspecialchars($client->getPrenom()) . " " . htmlspecialchars($client->getNom()) . " </h2>";
if ($client->estAdmin()) {
    echo "<div class='' id='admin'><p><strInfoAccountong>Administrateur</strong></p></div>";
}
echo "<hr>";
echo "<h2>Mes commandes</h2>";
echo "<p>Vous pouvez retrouver ici, l'historique de vos commandes.</p>";
$commandes = (new CommandeRepository())->getCommandeParIdClient($client->getMail());
require(__DIR__."/../commande/list.php");
echo "<hr>";
echo "<h2>Actions</h2>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=update&controller=client&email=" . rawurldecode(ConnexionClient::getLoginUtilisateurConnecte()) . "\">Modification des informations du compte</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=updatePassword&controller=client\">Modification du mot de passe</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?controller=client&action=logout\">Se déconnecter</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?controller=commande&action=readAll\">Voir commandes</button></p></div>";
echo "</section>";
