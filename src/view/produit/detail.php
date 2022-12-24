<?php
/** @var Produit $produit */


echo '<h1 class="h1Description">' . ucfirst($produit->getType()) . '</h1>';

/* Image */
echo '<section class="imageAfficheDescription">';
echo '<img class="imageDescription" src="../../images/' . $produit->getId() . '.png" alt="Image du bracelet">';
echo '</section>';

/* Description */

echo '<section class="description">';
echo '<div>'. '- ' . $produit->getNom() . '</div>';
echo '<div>'. '- ' . $produit->getMateriau() . '</div>';
echo '<div>'. '- ' . $produit->getDescription() . '</div>';
echo '<div class="lastDesc">' . $produit->getPrix() . ' € </div>';
echo '</section>';
?>