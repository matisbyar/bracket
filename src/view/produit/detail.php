<?php use App\Bracket\Lib\ConnexionClient; ?>

<div class="back-btn">
    <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg" alt="button retour"></i></button>
</div>

<div class="detail-container">
    <div class="detail-description-gauche">
        <p class="type-product-detail"><?= /** @var $produit */ strtoupper($produit->getType()) ?></p>
        <p class="title-product-detail"><?= substr(strstr($produit->getNom(), " "), 1) ?></p>
        <div>- <?= $produit->getMateriau() ?></div>
        <div>- <?= $produit->getDescription() ?></div>
        <div class="detail-description-prix"><?= $produit->getPrix() ?> € </div>
        <?php if (ConnexionClient::estAdministrateur()): ?>
            <div><button class="buttonOnForm" id="modification"><a href="?action=update&controller=produit&id=<?= $produit->getId() ?>">Modifier le produit</button></div>
        <?php endif; ?>
    </div>

    <div class="detail-description-droite">
        <img class="detail-image" src="<?= $produit->getImage() ?>" alt="Image du bracelet">
    </div>

</div>


