<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\Repository\ClientRepository;

?>
<div class="back-btn">
    <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg"
                                                                        alt="button retour"></i></button>
</div>

<form method="post" action="../web/index.php?controller=client&action=updated">
    <fieldset class="formAccountPlus">
        <legend>Mise à jour des informations</legend>
        <input type='hidden' name='action' value='created'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mailId">Adresse e-mail</label>
            <input class="InputAddOn-field" type="email" placeholder="Adresse e-mail" name="email" id="mailId"
                   value="<?= /* @var Client $client */
                   htmlspecialchars($client->getMail()); ?>" readonly/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomId">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="nom" name="nom" id="nomId"
                   value="<?= /* @var Client $client */
                   htmlspecialchars($client->getNom()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenomId">Prénom</label>
            <input class="InputAddOn-field" type="text" placeholder="prenom" name="prenom" id="nomId"
                   value="<?= /* @var Client $client */
                   htmlspecialchars($client->getPrenom()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="naissanceId">Date de naissance</label>
            <input class="InputAddOn-field" type="date" name="naissance" id="naissanceId"
                   value="<?= /* @var Client $client */
                   htmlspecialchars($client->getDateNaissance()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="adresseId">Adresse postale</label>
            <input class="InputAddOn-field" type="text" placeholder="Adresse postale" name="adresse" id="adresseId"
                   value="<?= /* @var Client $client */
                   htmlspecialchars($client->getAdresse()); ?>" required/>
        </p>
        <?php
        if(ConnexionClient::estAdministrateur()){
            echo '<p class="InputAddOn">
            <label class="InputAddOn-item" for="estAdmin_id" >Administrateur</label>
            <input class="InputAddOn-field" type="checkbox"' . ((new ClientRepository())->select($client->getMail())->estAdmin() ? "checked" : "") . ' name="estAdmin" id="estAdmin_id">
        </p>';
        }
        ?>
        <div class="buttonForm">
            <button class="buttonOnForm" role="button"><input type="submit" value=""/>Mettre à jour le compte</button>
        </div>
    </fieldset>
</form>