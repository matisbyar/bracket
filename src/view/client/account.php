<?php
use App\Bracket\Lib\ConnexionUtilisateur;
use App\Bracket\Model\Repository\ClientRepository;
$client = (new ClientRepository)->read(ConnexionUtilisateur::getLoginUtilisateurConnecte());
echo "<p><strong>Identifiant : </strong>".htmlspecialchars($client->getMail())."</p>";
echo "<p><strong>Nom : </strong>".htmlspecialchars($client->getNom())."</p>";
echo "<p><strong>Prénom : </strong>".htmlspecialchars($client->getPrenom())."</p>";
echo "<p><strong>Date de naissance : </strong>".htmlspecialchars($client->getDateNaissance())."</p>";
echo "<p><strong>Adresse : </strong>".htmlspecialchars($client->getAdresse())."</p>";
echo "<p><strong>Description : </strong>".htmlspecialchars($client->getDescription())."</p>";

echo "<p><a href=\"?action=update&controller=client&email=".rawurldecode(ConnexionUtilisateur::getLoginUtilisateurConnecte())."\">Modification des informations du compte</p>";
echo "<p><a href=\"?action=updatePassword&controller=client\">Modification du mot de passe</p>";
echo "<p><a href=\"?controller=client&action=logout\">Se déconnecter</p>";