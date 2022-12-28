<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\Repository\ClientRepository;

echo '<div class="back-btn"><button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg" alt="button retour"></i></button></div>';

$client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());
echo "<section class='subInfoCompte'>";
echo "<div class='infoCompte'><p><strong>Adresse e-mail :</strong> " . htmlspecialchars($client->getMail()) . "</p></div>";
echo "<div class='infoCompte'><p><strong>Nom :</strong> " . htmlspecialchars($client->getNom()) . "</p></div>";
echo "<div class='infoCompte'><p><strong>Prénom :</strong> " . htmlspecialchars($client->getPrenom()) . "</p></div>";
echo "<div class='infoCompte'><p><strong>Date de naissance :</strong> " . htmlspecialchars($client->getDateNaissance()) . "</p></div>";
echo "<div class='infoCompte'><p><strong>Adresse :</strong> " . htmlspecialchars($client->getAdresse()) . "</p></div>";
if ($client->estAdmin()) {
    echo "<div class='infoCompte' id='admin'><p><strong>Administrateur : </strong>Oui</p></div>";
}

echo "</section>";
echo "<section>";
if ($client->estAdmin()) {
    echo "<div class='infoCompteButton' ><p><button class='buttonOnForm' id='admin'><a href=\"?action=readAll&controller=client\">Accéder au panel admin</button></p></div>";
}
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=update&controller=client&email=" . rawurldecode(ConnexionClient::getLoginUtilisateurConnecte()) . "\">Modification des informations du compte</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=updatePassword&controller=client\">Modification du mot de passe</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?controller=client&action=logout\">Se déconnecter</button></p></div>";
echo "</section>";
