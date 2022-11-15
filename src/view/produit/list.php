<?php
/** @var Produit $produits */
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    echo '<p>' . "<a href=?action=read&id=" . $id . ">Produit " .
        htmlspecialchars($produit->getId()) . " ".htmlspecialchars($produit->getNom())." ➤</a>" ." <button><a href=?action=update&id=" .
        $id . "> Modifier</a> </button>  <button><a href=?action=deleted&id=" . $id .
        "> Supprimer</a> </button></p>";
}
?>