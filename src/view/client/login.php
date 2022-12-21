<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../css/styles.css"/>

</head>

<body>
<form method="post" action="../web/frontController.php?action=readAllBagues">
    <fieldset class="gauche">
        <legend>Création d'un compte</legend>
        <input type='hidden' name='action' value='created'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mailId">Mail</label>
            <input class="InputAddOn-field" type="email" placeholder="chuck@norris.us" name="mail" id="mailId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="passwordId">Mot de Passe</label>
            <input class="InputAddOn-field" type="password" placeholder="password" name="password" id="passwordId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="password2Id">Mail</label>
            <input class="InputAddOn-field" type="password" placeholder="password" name="password2" id="password2Id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomId">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="Norris" name="nom" id="nomId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenomId">Prénom</label>
            <input class="InputAddOn-field" type="text" placeholder="Chuck" name="nom" id="nomId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="naissanceId">Date de naissance</label>
            <input class="InputAddOn-field" type="date" placeholder="10-12-2003" name="naissance" id="naissanceId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="adresseId">Adresse</label>
            <input class="InputAddOn-field" type="text" placeholder="9350 Wilshire Boulevard" name="adresse" id="adresseId">
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
    <fieldset>
        <legend>Connexion</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login</label>
            <input class="InputAddOn-field" type="text" placeholder="login" name="login" id="login_id" required/><br>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Mot de passe</label>
            <input class="InputAddOn-field" type="text" placeholder="***********" name="motdepasse" id="nom_id" required/><br>
        </p>
        <p>
            <input type="submit" value="connecter"/>
            <input type='hidden' name='action' value='connecter'/>
        </p>
    </fieldset>
</form>
</body>
</html>