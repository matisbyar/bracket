<?php
/** @var Produit $produits */
echo '<div class="wrapper">';
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    echo '<div class="produit">';
    echo "<div class='haut'>Haut</div>";

    echo '<div class="bas">' . "<a href=?action=read&id=" . $id . ">Produit " .
        htmlspecialchars($produit->getId()) . " " . htmlspecialchars($produit->getNom()) . "</a></div>";

    echo '</div>';
}
echo "</div>" ?>