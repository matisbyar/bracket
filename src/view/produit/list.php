<?php
/** @var Produit $produits */
echo '<div class="wrapper">';
foreach ($produits as $produit) {
    $id = rawurlencode($produit->getId());
    ?>
    <?php echo '<div>' . "<a href=?action=read&id=" . $id . ">Produit " .
        htmlspecialchars($produit->getId()) . " ".htmlspecialchars($produit->getNom())."</a></div>";
    ?>
<?php } echo "</div>" ?>