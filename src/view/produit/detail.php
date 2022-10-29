<?php
echo '<h1>' . ucfirst($produit->getType()) . '</h1>';
echo '<p>' . $produit->getPrix() . ' € — ' . $produit->getMateriau() . ' — ' . $produit->getCouleur() . ' — ' . $produit->getTaille() . '</p>';
?>