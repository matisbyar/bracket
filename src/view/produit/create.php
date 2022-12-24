<form action="../web/frontController.php">
    <fieldset>
        <legend>Création d'un bijou</legend>
        <input type='hidden' name='action' value='created'>
        <fieldset>
            <legend>Choix du type</legend>
            <div>
                <input type="radio" id="bagueId" name="bijou" value="bague" checked>
                <label for="bagueId">Bague</label>
            </div>
            <div>
                <input type="radio" id="braceletId" name="bijou" value="bracelet">
                <label for="braceletId">Bracelet</label>
            </div>
        </fieldset>
        <p>
            <label for="prixId">Prix</label> :
            <input type="number" placeholder="150" name="prix" id="prixId" required/>
        </p>
        <p>
            <label for="materiauId">Matériau</label> :
            <select name="materiau" size="1" id="materiauId">
                <option>Acier Inoxydable</option>
                <option>Argent</option>
                <option>Or</option>
                <option>Plaque Or</option>
                <option>Tissus</option>
            </select>
        </p>
        <p>
            <label for="nomId">Nom</label> :
            <input type="text" placeholder="Bracelet Georges" name="nom" id="nomId" required/>
        </p>
        <p>
            <label for="descriptionId">Description</label> :
            <input type="text" placeholder="" name="description" id="descriptionId" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>