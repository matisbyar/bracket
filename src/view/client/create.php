<form action="../web/frontController.php">
    <fieldset>
        <legend>Création d'un compte</legend>
        <input type='hidden' name='action' value='created'>
        <p>
            <label for="mailId">Mail</label> :
            <input type="email" placeholder="chuck@norris.us" name="mail" id="mailId" required/>
        </p>
        <p>
            <label for="passwordId">Mot de Passe</label> :
            <input type="password" placeholder="password" name="password" id="passwordId" required/>
        </p>
        <p>
            <label for="password2Id">Mail</label> :
            <input type="password" placeholder="password" name="password2" id="password2Id" required/>
        </p>
        <p>
            <label for="nomId">Nom</label> :
            <input type="text" placeholder="Norris" name="nom" id="nomId" required/>
        </p>
        <p>
            <label for="prenomId">Prénom</label> :
            <input type="text" placeholder="Chuck" name="nom" id="nomId" required/>
        </p>
        <p>
            <label for="naissanceId">Date de naissance</label> :
            <input type="date" placeholder="10-12-2003" name="naissance" id="naissanceId" required/>
        </p>
        <p>
            <label for="adresseId">Adresse</label> :
            <input type="text" placeholder="9350 Wilshire Boulevard" name="adresse" id="adresseId">
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>