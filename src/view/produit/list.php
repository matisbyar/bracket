<?php
/** @var Produit $produits */
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    ?><div class="wrapper">
    <?php echo '<div>' . "<a href=?action=read&id=" . $id . ">Produit " .
        htmlspecialchars($produit->getId()) . " ".htmlspecialchars($produit->getNom())." ➤</a></div>";
    ?></div>
<?php } ?>