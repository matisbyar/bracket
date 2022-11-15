<?php
/** @var Produit $produit */
echo '<h1>' . ucfirst($produit->getType()) . '</h1>';
echo '<p>' . $produit->getNom() . ' — '
    .$produit->getPrix() . ' € — '
    . $produit->getMateriau() .
    ' — '. $produit->getDescription().'</p>';
?>