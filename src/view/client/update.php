<form action="../web/frontController.php">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <input type='hidden' name='action' value='updated'>
        <p>
            <label for="email_id">Email</label> :
            <input type="text" value="<?= /* @var Client $client */ htmlspecialchars($client->getMail()); ?>" name="mail" id="email_id" readonly/>
        </p>
        <p>
            <label for="nom_id">Nom</label> :
            <input type="text" value="<?= /* @var Client $client */ htmlspecialchars($client->getNom()); ?>" name="nom" id="nom_id" required/>
        </p>
        <p>
            <label for="prenom_id">Prenom</label> :
            <input type="text" value="<?= /* @var Client $client */ htmlspecialchars($client->getPrenom()); ?>" name="prenom" id="prenom_id" required/>
        </p>
        <p>
            <label for="dateN_id">Date de naissance</label> :
            <input type="text" value="<?= /* @var Client $client */ htmlspecialchars($client->getDateNaissance()); ?>" name="dateN" id="dateN_id" required/>
        </p>
        <p>
            <label for="adresse_id">Adresse</label> :
            <input type="text" value="<?= /* @var Client $client */ htmlspecialchars($client->getAdresse()); ?>" name="adresse" id="adresse_id" required/>
        </p>
        <p>
            <label for="password_id">Mot de passe</label> :
            <input type="text" value="<?= /* @var Client $client */ htmlspecialchars($client->getPassword()); ?>" name="password" id="password_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>