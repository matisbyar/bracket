<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../css/styles.css"/>
</head>
<body>

<div class="back-btn">
    <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg"
                                                                        alt="button retour"></i></button>
</div>

<form method="post" action="../web/frontController.php?controller=client&action=updatedPassword">
    <fieldset class="formAccountPlus">
        <legend>Mise à jour du mot de passe</legend>
        <input type='hidden' name='action' value='created'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="oldPasswordId">Ancien mot de passe</label>
            <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="oldPassword"
                   id="oldPasswordId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="passwordId">Nouveau mot de passe</label>
            <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="password" id="passwordId"
                   required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="password2Id">Confirmation du mot de passe</label>
            <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="password2Id"
                   id="password2Id" required/>
        </p>
        <div class="buttonForm">
            <button class="buttonOnForm" role="button"><input type="submit" value=""/>Mettre à jour le compte</button>
        </div>
    </fieldset>
</form>