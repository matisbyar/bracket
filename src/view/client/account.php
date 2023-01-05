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
    echo "<div class='InfoAccount' id='admin'><p><strInfoAccountong>Administrateur</strong></p></div>";
}
echo "<h2 class='InfoAccount' id='info'> " . htmlspecialchars($client->getAdresse()) . " • "  . htmlspecialchars($client->getDateNaissance()) . " </h2>";
echo "<hr>";
?>
<div class="titres-home">
    <h1 class="commande_action">Mes commandes</h1>
    <a class="sous-titre-home" href="?controller=commande&action=readAll">Voir plus ></a>
</div>
<?php
echo "<p class='commande_action'>Vous pouvez retrouver ici, l'historique de vos commandes.</p>";
$commandes = (new CommandeRepository())->getCommandeParIdClient($client->getMail());
if (sizeof($commandes) == 0) {
    echo "<p class='panier-alert'>Vous n'avez pas encore passé de commande !</p>";
} else {
    echo "<div class='commande_action'>";
    require(__DIR__ . "/../commande/list.php");
    echo "</div>";
}
echo "<hr>";
echo "<h2 class='commande_action'>Actions</h2>";
echo "<div class='actionCompte'>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=update&controller=client&email=" . rawurldecode(ConnexionClient::getLoginUtilisateurConnecte()) . "\">Modification des informations du compte</a></button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=updatePassword&controller=client\">Modification du mot de passe</a></button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm' id='deconnecter'><a href=\"?controller=client&action=logout\">Se déconnecter</a></button></p></div>";
echo "</div>";
echo "</section>";
