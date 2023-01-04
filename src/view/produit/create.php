<div class="back-btn">
    <button onclick="history.go(-1);"><img src="../images/backPage.svg" alt="button retour"></i></button>
</div>

<form>
    <fieldset>
        <legend>Création d'un bijou</legend>
        <input type="hidden" name="controller" value="produit">
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
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prixId">Prix</label>
            <input class="InputAddOn-field" type="number" placeholder="150" name="prix" id="prixId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="materiauId">Matériau</label>
            <select class="InputAddOn-field" name="materiau" size="1" id="materiauId">
                <option>Acier Inoxydable</option>
                <option>Argent</option>
                <option>Or</option>
                <option>Plaque Or</option>
                <option>Tissus</option>
            </select>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomId">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="Bracelet Georges" name="nom" id="nomId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="descriptionId">Description</label>
            <input class="InputAddOn-field" type="text" placeholder="" name="description" id="descriptionId" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="imageId">Lien de l'image</label>
            <input class="InputAddOn-field" type="text" placeholder="" name="image" id="imageId" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>