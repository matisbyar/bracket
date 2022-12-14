<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion</title>
</head>

<body>
<form method="post" action="../web/frontController.php?action=readAllBagues">
    <fieldset>
        <legend>Connexion</legend>
        <p>
            <label for="login_id">Login</label> :
            <input type="text" placeholder="login" name="login" id="login_id" required/><br>
            <label for="login_id">Mot de passe</label> :
            <input type="text" placeholder="***********" name="motdepasse" id="nom_id" required/><br>
        </p>
        <p>
            <input type="submit" value="connecter"/>
            <input type='hidden' name='action' value='connecter'/>
        </p>
    </fieldset>
</form>
</body>
</html>