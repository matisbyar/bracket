<?php
/** @var Produit $produits */
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    echo '<p>' . "<a href=?action=read&id=" . $id . ">Produit " .
        htmlspecialchars($produit->getId()) . " ".htmlspecialchars($produit->getNom())." ➤</a>";
}
?>