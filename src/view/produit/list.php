<?php

use App\Bracket\Model\DataObject\Produit;
/** @var Produit $produits */
echo '<div class="wrapper">';
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    echo '<a href="?action=read&id=' . $id .'" class="produit-a"><div class="produit">';
    echo "<div class='haut'><img src='" . $produit->getImage() . "' alt='Produit'></div>";

    echo '<div class="bas">' . "
            <p class='type-product-pane'>" . strtoupper($produit->getType()) . "</p>
            <p class='title-product-pane'>" . substr(strstr($produit->getNom(), " "), 1) . "</p>
            <p class='info-product-pane'>" . $produit->getMateriau() . "</p>
            <div class='bottom-product-pane'>
                <p class='info-product-pane'>" . $produit->getPrix() . "€</p>
                <button><img src='../images/read_product.svg' alt='detail'></button>
            </div>
            
        </div>";

    echo '</div></a>';
}
echo "</div>" ?>