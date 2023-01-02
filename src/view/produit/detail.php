<?php use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\Repository\AvisRepository;
use App\Bracket\Model\Repository\ClientRepository;
use App\Bracket\Model\Repository\ProduitRepository;

/** @var $produit */ ?>

<div class="back-btn">
    <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg"
                                                                        alt="button retour"></i></button>
</div>

<div class="detail-container">
    <div class="detail-description-gauche">
        <img class="detail-image" src="<?= $produit->getImage() ?>" alt="Image du bracelet">
    </div>

    <div class="detail-description-droite">
        <p class="type-product-detail"><?= strtoupper($produit->getType()) ?></p>
        <p class="title-product-detail"><?= substr(strstr($produit->getNom(), " "), 1) ?></p>
        <ul>
            <li><?= $produit->getMateriau() ?></li>
            <li><?= $produit->getDescription() ?></li>
        </ul>

        <form action="?frontController.php?controller=produit&action=test" method="post" id="ajout-panier">
            <h2 class="choice-product-detail">Choisissez la couleur</h2>
            <div class="choice">
                <?php
                $couleurs = [];
                $checked = sizeof($couleurs) == 0 ? "checked" : "";
                $articles = (new ProduitRepository())::getDisponibles($produit->getId());
                foreach ($articles as $articlesDispo) {
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
                foreach ($articles as $articlesDispo) {
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
        </form>

        <div class="detail-description-prix"><?= $produit->getPrix() ?> €</div>

        <?php if (ConnexionClient::estAdministrateur()) echo '<div><button class="buttonOnForm" id="modification"><a href="?action=update&controller=produit&id=' . $produit->getId() . '">Modifier le produit</a></button></div>'; ?>
    </div>
</div>
<hr>
<div class="panneau-avis-product-detail">
    <h2 class="title-avis-product-detail">Avis</h2>
    <p class="subtitle-avis-product-detail">Que disent les autres acheteurs de ce produit ?</p>
    <div class="list-avis-product-detail">
        <?php
        $listeAvis = (new AvisRepository())->getAvisByBijou($produit->getId());
        $listeEstVide = sizeof($listeAvis) == 0;
        if ($listeEstVide) {
            echo '<p class="subtitle-avis-product-detail">Aucun avis pour le moment...</p>';
        } else {
            foreach ($listeAvis as $avis) {
                $client = (new ClientRepository())->getClientByEmail($avis->getMailClient());

                echo '<div class="avis-product-detail">';
                echo '<p class="avis-product-detail-nom-prenom">' . $client->getPrenom() . '</p>';
                // Affiche les étoiles
                $etoiles = "";
                for ($i = 0; $i < 5; $i++) {
                    $etoiles .= $i > $avis->getNote() - 1 ? '<img class="fas fa-star-empty" src="../../../images/star-empty.svg" alt="Étoile vide"/>' : '<img class="fas fa-star" src="../../images/star-solid.svg" alt="Étoile pleine"/>';
                }
                echo '<p class="avis-product-detail-note">' . $etoiles . '</p>';

                // Affiche les avis
                echo '<p class="avis-product-detail-commentaire">' . $avis->getAvis() . '</p>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<div class="laisser-avis">
    <h2 class="title-avis-product-detail">Laissez le vôtre !</h2>
    <p class="subtitle-avis-product-detail">Votre avis nous intéresse.</p>
    <?php
    if (ConnexionClient::estConnecte()) {
        echo '<div class="avis-product-detail-form">
                <form action="?controller=avis&action=ajouterAvis" method="post" id="laisser-avis-id">
                    <input type="hidden" name="mailClient" value="' . ConnexionClient::getLoginUtilisateurConnecte() . '">
                    <input type="hidden" name="idBijou" value="' . $produit->getId() . '">
                    <div class="avis-product-detail-form-note">
                        <p class="avis-product-detail-form-note-title">Note</p>
                        <select name="note" class="avis-product-detail-form-note-etoiles-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="avis-product-detail-form-commentaire">
                        <p class="avis-product-detail-form-commentaire-title">Commentaire</p>
                        <textarea name="avis" cols="30" rows="10"></textarea>
                    </div>
                
                    <div class="avis-product-detail-form-btn">
                        <input type="submit" value="Envoyer" form="laisser-avis-id">
                    </div>
                </form>
            </div>';
    } else {
        echo '<p class="avis-product-detail-form-connect">Connectez-vous pour laisser un avis !</p>';
    }
    ?>
</div>


