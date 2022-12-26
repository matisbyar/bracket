<?php
/** @var Produit $produits */
echo '<div class="wrapper">';
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    echo '<a href="?action=read&id=' . $id .'" class="produit-a"><div class="produit">';
    echo "<div class='haut'><img src='../images/" . $produit->getId() . ".png' alt='Produit'></div>";

    echo '<div class="bas">' . "
            <p class='title-product-pane'>" . $produit->getNom() . "</p>
            <p class='info-product-pane'>" . $produit->getMateriau() . "</p>
            <div class='bottom-product-pane'>
                <p class='info-product-pane'>" . $produit->getPrix() . "€</p>
                <button><img src='../images/read_product.svg' alt='detail'></button>
            </div>
            
        </div>";

    echo '</div></a>';
}
echo "</div>" ?>