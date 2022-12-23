<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../css/styles.css"/>
</head>
<body>
<p></p>
<form method="post" action="../web/frontController.php?controller=client&action=updated">
    <fieldset class="fieldsetLeft">
        <legend>Mise à jour des informations</legend>
        <input type='hidden' name='action' value='created'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mailId">Adresse e-mail</label>
            <input class="InputAddOn-field" type="email" placeholder="Adresse e-mail" name="mail" id="mailId" 
                value="<?= /* @var Client $client */ htmlspecialchars($client->getMail()); ?>" readonly/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomId">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="nom" name="nom" id="nomId"
                value="<?= /* @var Client $client */ htmlspecialchars($client->getNom()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenomId">Prénom</label>
            <input class="InputAddOn-field" type="text" placeholder="prenom" name="prenom" id="nomId"
            value="<?= /* @var Client $client */ htmlspecialchars($client->getPrenom()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="naissanceId">Date de naissance</label>
            <input class="InputAddOn-field" type="date" name="naissance" id="naissanceId"
                value="<?= /* @var Client $client */ htmlspecialchars($client->getDateNaissance()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="adresseId">Adresse postale</label>
            <input class="InputAddOn-field" type="text" placeholder="Adresse postale" name="adresse" id="adresseId"
                value="<?= /* @var Client $client */ htmlspecialchars($client->getAdresse()); ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="oldPasswordId">Ancien mot de passe</label>
            <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="password" id="oldPasswordId" required/>
        </p>
        <div class="buttonForm">
            <button class="buttonOnForm" role="button"><input type="submit" value=""/>Mettre à jour le compte</button>
        </div>
    </fieldset>
</form>