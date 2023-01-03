<div class="login-title">
    <h1>Compte Bracket</h1>
    <p>Connectez-vous ou inscrivez-vous pour avoir le <strong>meilleur de Bracket</strong>. Vous verrez, vous adorerez.</p>
</div>
<div class="login-container">
    <form method="post" action="../web/frontController.php?controller=client&action=create">
        <fieldset>
            <legend>Je n'ai pas encore de compte</legend>
            <input type='hidden' name='action' value='created'>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="nomId">Nom&#42;</label>
                <input class="InputAddOn-field" type="text" placeholder="nom" name="nom" id="nomId"
                       required/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="prenomId">Prénom&#42;</label>
                <input class="InputAddOn-field" type="text" placeholder="prenom" name="prenom" id="nomId" required/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="naissanceId">Date de naissance&#42;</label>
                <input class="InputAddOn-field" type="date" name="naissance" id="naissanceId"
                       required/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="mailId">Adresse e-mail&#42;</label>
                <input class="InputAddOn-field" type="email" placeholder="Adresse e-mail" name="mail" id="mailId"
                       required/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="adresseId">Adresse postale</label>
                <input class="InputAddOn-field" type="text" placeholder="Adresse postale" name="adresse"
                       id="adresseId">
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="passwordId">Mot de Passe&#42;</label>
                <input class="InputAddOn-field" type="password" placeholder="Mot de passe" name="password" id="passwordId"
                       required/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="password2Id">Confirmation&#42;</label>
                <input class="InputAddOn-field" type="password" placeholder="Confirmez votre mot de passe" name="password2"
                       id="password2Id"
                       required/>
            </p>
            <div class="buttonForm">
                <button class="buttonOnForm" role="button"><input type="submit" value=""/>Créer un compte</button>
            </div>
        </fieldset>
    </form>
    <form method="post" action="../web/frontController.php?controller=client&action=connecter">
        <fieldset>
            <legend>J'ai déjà un compte</legend>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="emailId">Adresse e-mail&#42;</label>
                <input class="InputAddOn-field" type="text" placeholder="Identifiant" name="email" id="emailId"
                       required/><br>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="passwordId">Mot de passe&#42;</label>
                <input class="InputAddOn-field" type="password" placeholder="***********" name="password" id="passwordId"
                       required/><br>
            </p>
            <div class="buttonForm">
                <button class="buttonOnForm" role="button"><input type="submit" value=""/>Se connecter</button>
            </div>
        </fieldset>
    </form>
</div>
<p class="champs-obligatoires">Les champs marqués d'une &#42; sont obligatoires.</p>
