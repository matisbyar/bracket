<?php
echo '<h1>' . ucfirst($produit->getType()) . '</h1>';
echo '<p>' . $produit->getNom() . ' — '
    .$produit->getPrix() . ' € — '
    . $produit->getMateriau() . ' — ' . $produit->getCouleur()
    . ' — ' . $produit->getTaille() .
    ' — '. $produit->getDescription().'</p>';
?>