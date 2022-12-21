<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../css/styles.css"/>
</head>
<body>
<form method="post" action="../web/frontController.php?controller=client&action=creer">
    <fieldset class="fieldsetLeft">
        <legend>Création d'un compte</legend>
        <input type='hidden' name='action' value='created'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomId">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="nom" name="nom" id="nomId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenomId">Prénom</label>
            <input class="InputAddOn-field" type="text" placeholder="prenom" name="prenom" id="nomId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="naissanceId">Date de naissance</label>
            <input class="InputAddOn-field" type="date" name="naissance" id="naissanceId"
                   required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mailId">Adresse e-mail</label>
            <input class="InputAddOn-field" type="email" placeholder="Adresse e-mail" name="mail" id="mailId"
                   required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="adresseId">Adresse postale</label>
            <input class="InputAddOn-field" type="text" placeholder="Adresse postale" name="adresse"
                   id="adresseId">
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="passwordId">Mot de Passe</label>
            <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="password" id="passwordId"
                   required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="password2Id">Confirmation</label>
            <input class="InputAddOn-field" type="password" placeholder="Confirmation mot de passe" name="password2" id="password2Id"
                   required/>
        </p>
        <div class="buttonForm">
            <button class="buttonOnForm" role="button"><input type="submit" value=""/>Créer un compte</button>
        </div>
    </fieldset>
</form>
<form method="post" action="../web/frontController.php?controller=client&action=connecter">
    <fieldset>
        <legend>Connexion</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Identifiant</label>
            <input class="InputAddOn-field" type="text" placeholder="Identifiant" name="login" id="login_id" required/><br>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Mot de passe</label>
            <input class="InputAddOn-field" type="text" placeholder="***********" name="motdepasse" id="nom_id"
                   required/><br>
        </p>
        <div class="buttonForm">
            <button class="buttonOnForm" role="button"><input type="submit" value=""/>Se connecter</button>
        </div>
    </fieldset>
</form>
</body>
</html>