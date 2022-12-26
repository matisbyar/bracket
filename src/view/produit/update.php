<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Connexion</title>
    <link rel="stylesheet" href="../../../css/styles.css"/>
</head>
<body>

<div class="back-btn">
    <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg"
                                                                        alt="button retour"></i></button>
</div>

<form method="post" action="../web/frontController.php?controller=produit&action=updated">
    <fieldset>
        <legend>Création d'un bijou</legend>
        <p>
            <label for="idId">Identifiant du produit</label> :
            <input type="int" value="<?= /* @var Produit $produit */
                   htmlspecialchars($produit->getId()); ?>" name="id" id="idId" readonly/>
        </p>
        <p>
            <label for="prixId">Prix</label> :
            <input type="number" value="<?= /* @var Produit $produit */
                   htmlspecialchars($produit->getPrix()); ?>" name="prix" id="prixId" required/>
        </p>
        <p>
            <label for="nomId">Nom</label> :
            <input type="text" value="<?= /* @var Produit $produit */
                   htmlspecialchars($produit->getNom()); ?>" name="nom" id="nomId" required/>
        </p>
        <p>
            <label for="descriptionId">Description</label> :
            <input type="text" value="<?= /* @var Produit $produit */
                   htmlspecialchars($produit->getDescription()); ?>" name="description" id="descriptionId" required/>
        </p>
        <p>
            <label for="imageId">Lien de l'image</label> :
            <input type="text" value="<?= /* @var Produit $produit */
                   htmlspecialchars($produit->getImage()); ?>" name="image" id="imageId" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer"/>
        </p>
    </fieldset>
</form>