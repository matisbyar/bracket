<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\Repository\ClientRepository;
use App\Bracket\Model\Repository\PanierRepository;
use App\Bracket\Model\Repository\ProduitRepository;

$client = (new ClientRepository)->select(ConnexionClient::getLoginUtilisateurConnecte());
$panier = (new PanierRepository)->selectPanierFromClient(ConnexionClient::getLoginUtilisateurConnecte());

?>

<div class="login-title">
    <h1>Mon panier</h1>
    <p>Retrouvez les merveilles que vous venez de dénicher.</p>
</div>

<?php
foreach($panier as $ligne) {
    $article = (new ProduitRepository)->getProduitParId($ligne->getIdArticle());
echo '<div class="panier-article">
        <div class="panier-article-image">
            <img src="' . $article->getImage() . '" alt="' . $article->getNom() . '">
        </div>
        <div class="panier-article-info">
            <h2>' . $article->getNom() . '</h2>
            <p>' . $article->getDescription() . '</p>
            <p>' . $article->getPrix() . '€</p>
            <p>Quantité : ' . $ligne->getQuantite() . '</p>
            <a href="?controller=client&action=deleteFromBasket&idArticle=' . $article->getId() . '">Supprimer</a>
        </div>
    </div>';
    ?>
    <div>

    </div>
<?php } ?>