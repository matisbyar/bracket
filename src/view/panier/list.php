<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\DataObject\Panier;
use App\Bracket\Model\Repository\ArticleRepository;
use App\Bracket\Model\Repository\ClientRepository;
use App\Bracket\Model\Repository\PanierRepository;
use App\Bracket\Model\Repository\ProduitRepository;

/* @var $panier Panier */
?>

<div class="login-title">
    <h1>Mon panier</h1>
    <p>Retrouvez les merveilles que vous venez de dénicher.</p>
</div>

<?php
if (ConnexionClient::estConnecte()) {
    $client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());
    $panier = (new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte());
    if (sizeof($panier) == 0) {
        echo "<p>Vous n'avez pas encore ajouté d'articles à votre panier !</p>";
    } else {
        foreach ($panier as $ligne) {
            $article = (new ProduitRepository)->getProduitParId($ligne->getIdArticle());
            echo '<div class="panier-article">
            <div class="panier-article-image">
                <img src="' . $article->getImage() . '" alt="' . $article->getNom() . '" class="panier-article-image">
            </div>
            <div class="panier-article-info">
                <h2>' . $article->getNom() . '</h2>
                <div class="panier-article-description">
                    <p>' . $article->getDescription() . '</p>
                <p>Quantité : ' . $ligne["ligne"]["quantite"] . '</p>
                <p>' . $article->getPrix() . '€</p>
                </div>
            </div>
            <div class="panier-article-actions">
                <button><a href="?controller=produit&action=read&id="' . $article->getId() . '">Consulter</a></button>
                <button><a href="?controller=panier&action=deleteFromBasket&idArticle=' . $article->getId() . '">Supprimer</a></button>
</div>
        </div>';
        }
        ?>
        <div>

        </div>
    <?php }
} else {
    if (sizeof($panier) == 0) {
        echo "<p class='panier-alert'>Vous n'avez pas encore ajouté d'articles à votre panier !</p>";
    } else {
        foreach ($panier as $ligne) {
            /**
             * Pour récupérer une ligne de commande, on cherche dans la matrice :
             *  $ligne[ligne][article OU quantite]
             * Il est important de spécifier la ligne de commande, puisque celle-ci est un tableau de tableaux, donc une représentation matricielle.
             * Pour récupérer l'article, on utilise la clé "article", et pour récupérer la quantité, on utilise la clé "quantite".
             */
            $idArticle = (new ArticleRepository())->getIdArticleParClesPrimaires($ligne["ligne"]["article"]->getIdBijou(), $ligne["ligne"]["article"]->getCouleur(), $ligne["ligne"]["article"]->getTaille());
            $article = (new ProduitRepository)->getProduitParId($idArticle);
            echo '<div class="panier-article">
            <div class="panier-article-image">
                <img src="' . $article->getImage() . '" alt="' . $article->getNom() . '" class="panier-article-image">
            </div>
            <div class="panier-article-info">
                <h2>' . $article->getNom() . '</h2>
                <div class="panier-article-description">
                    <p>' . $article->getDescription() . '</p>
                <p>Quantité : ' . $ligne["ligne"]["quantite"] . '</p>
                <p>' . $article->getPrix() . '€</p>
                </div>
            </div>
            <div class="panier-article-actions">
                <button><a href="?controller=produit&action=read&id=' . $article->getId() . '">Consulter</a></button>
                <button><a href="?controller=panier&action=deleteFromBasket&idArticle=' . $article->getId() . '">Supprimer</a></button>
</div>
        </div>';
        }
    }
} ?>