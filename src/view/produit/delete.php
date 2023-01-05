<?php /** @var Produit $produits */ ?>

<div class="back-btn">
    <button onclick="history.go(-1);"><img src="../images/backPage.svg" alt="button retour"></button>
</div>
<form action="../web/index.php">
    <fieldset>
        <legend>Suppression d'un bijou</legend>
        <input type="hidden" name="controller" value="produit">
        <input type='hidden' name='action' value='deleted'>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="produitId">Produit</label>
            <select class="InputAddOn-field" name="id" size="1" id="produitId">
                <?php foreach ($produits as $produit) : ?>
                    <option value="<?= $produit->getId() ?>"><?= $produit->getNom() ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>