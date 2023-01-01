<?php use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\Repository\ProduitRepository;
/** @var $produit */?>

<div class="back-btn">
    <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg" alt="button retour"></i></button>
</div>

<div class="detail-container">
    <div class="detail-description-gauche">
        <img class="detail-image" src="<?= $produit->getImage() ?>" alt="Image du bracelet">
    </div>

    <div class="detail-description-droite">
        <p class="type-product-detail"><?=  strtoupper($produit->getType()) ?></p>
        <p class="title-product-detail"><?= substr(strstr($produit->getNom(), " "), 1) ?></p>
        <ul>
            <li><?= $produit->getMateriau() ?></li>
            <li><?= $produit->getDescription() ?></li>
        </ul>

        <!-- make a form list of radio buttons in div to select color with the label clickable -->
        <form action="?frontController.php?controller=produit&action=test" method="post">
            <h2 class="choice-product-detail">Choisissez la couleur</h2>
            <div class="choice">
            <?php
            $couleurs = [];
            $checked = sizeof($couleurs) == 0 ? "checked" : "";
            $articles = (new ProduitRepository())::getDisponibles($produit->getId());
                foreach($articles as $articlesDispo) {
                    if (!in_array($articlesDispo->getCouleur(), $couleurs)) {
                        echo '<div class="list-choice">
                            <input type="radio" id="' . $articlesDispo->getCouleur() . '" name="color" value="' . $articlesDispo->getCouleur() . '" checked="' . $checked . '">
                            <label for="' . $articlesDispo->getCouleur() . '">' . $articlesDispo->getCouleur() . '</label>
                        </div>';
                    }
                    $couleurs[] = $articlesDispo->getCouleur();
                }
            ?>
            </div>
            <h2 class="choice-product-detail">Choisissez la taille</h2>
            <div class="choice">
            <?php
            $tailles = [];
            $checked = sizeof($tailles) == 0 ? "checked" : "";
            foreach($articles as $articlesDispo) {
                if (!in_array($articlesDispo->getTaille(), $tailles)) {
                    echo '<div class="list-choice">
                            <input type="radio" id="' . $articlesDispo->getTaille() . '" name="size" value="' . $articlesDispo->getTaille() . '" checked ="' . $checked . '">
                            <label for="' . $articlesDispo->getTaille() . '">' . $articlesDispo->getTaille() . '</label>
                        </div>';
                }
            }
            ?>
            </div>
            <div class="detail-btn">
                <button type="submit" name="ajouterAuPanier" value="<?= $produit->getId() ?>">Ajouter au panier</button>
            </div>

            <div class="detail-description-prix"><?= $produit->getPrix() ?> € </div>

            <?php if (ConnexionClient::estAdministrateur()) echo '<div><button class="buttonOnForm" id="modification"><a href="?action=update&controller=produit&id=' . $produit->getId() . '">Modifier le produit</a></button></div>'; ?>
    </div>

</div>


