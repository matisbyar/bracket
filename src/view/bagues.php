<?php
/** @var Produit $produits */
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    echo '<p>' . "<a href=?action=bagues&id=" . $id . ">Bagues " .
        htmlspecialchars($produit->getId()) . " ".htmlspecialchars($produit->getNom())." ➤</a>";
}
