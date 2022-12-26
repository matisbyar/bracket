<?php
use App\Bracket\Lib\ConnexionUtilisateur;
use App\Bracket\Model\Repository\ClientRepository;

?>
    <div class="back-btn">
        <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg"
                                                                            alt="button retour"></i></button>
    </div>
<?php

$client = (new ClientRepository)->read(ConnexionUtilisateur::getLoginUtilisateurConnecte());
//var_dump($client);
echo "<section class='subInfoCompte'>";
echo "<div class='infoCompte'><p><strong>Identifiant :</strong> ".htmlspecialchars($client->getMail())."</p></div>";
echo "<div class='infoCompte'><p><strong>Nom :</strong> ".htmlspecialchars($client->getNom())."</p></div>";
echo "<div class='infoCompte'><p><strong>Prénom :</strong> ".htmlspecialchars($client->getPrenom())."</p></div>";
echo "<div class='infoCompte'><p><strong>Date de naissance :</strong> ".htmlspecialchars($client->getDateNaissance())."</p></div>";
echo "<div class='infoCompte'><p><strong>Adresse :</strong> ".htmlspecialchars($client->getAdresse())."</p></div>";
if ($client->isEstAdmin()) {
    echo "<div class='infoCompte'><p><strong>Administrateur : </strong>Oui</p></div>";
    echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=readAll&controller=client\">Accéder au panel admin</button></p></div>";
}else{
    echo "<div class='infoCompte'><p><strong>Administrateur : </strong>Non</p></div>";
}
echo "</section>";
echo "<section>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=update&controller=client&email=".rawurldecode(ConnexionUtilisateur::getLoginUtilisateurConnecte())."\">Modification des informations du compte</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?action=updatePassword&controller=client\">Modification du mot de passe</button></p></div>";
echo "<div class='infoCompteButton'><p><button class='buttonOnForm'><a href=\"?controller=client&action=logout\">Se déconnecter</button></p></div>";
echo "</section>";
