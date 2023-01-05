<div class="back-btn">
    <button onclick="history.go(-1);"><img src="../images/backPage.svg" alt="button retour"></i></button>
</div>

<form>
    <fieldset>
        <legend>Ajout d'un article</legend>
        <input type="hidden" name="controller" value="article">
        <input type='hidden' name='action' value='created'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="idBijou">Produit</label>
            <select class="InputAddOn-field" name="idBijou" size="1" id="idBijou">
                <?php foreach ($produits as $produit) : ?>
                    <option value="<?= $produit->getId() ?>"><?= $produit->getNom() ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="couleurId">Couleur</label>
            <select class="InputAddOn-field" value="<?php if (isset($_REQUEST['couleur'])) echo $_REQUEST['couleur']; ?>" name="couleur" size="1" id="couleurId">
                <option>Argent</option>
                <option>Argent Blanc</option>
                <option>Argent Rose</option>
                <option>Or</option>
                <option>Or Rose</option>
                <option>Tissus Gris</option>
            </select>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="tailleId">Taille</label>
            <select class="InputAddOn-field" value="<?php if (isset($_REQUEST['taille'])) echo $_REQUEST['taille']; ?>" name="taille" size="1" id="tailleId">
                <option>32-34</option>
                <option>36-38</option>
                <option>40/42</option>
                <option>L/XL</option>
                <option>M/L</option>
                <option>S/M</option>
                <option>Taille unique</option>
            </select>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="quantiteId">Quantité</label>
            <input class="InputAddOn-field" type="number" placeholder="" name="quantite" id="quantiteId" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>