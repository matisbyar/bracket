<?<?php
/** @var Commande $commande */
echo "<section>";
echo "<h2>Commande n°" . htmlspecialchars($commande->getId()) . "</h2>";
echo "Livré à : " . htmlspecialchars($commande->getAdresse()) . "<br>";
echo "Liste des produits : ";
echo "<ul>";
foreach ($commande->getProduits() as $produit) {
    echo "<li>" . htmlspecialchars($produit->getNom()) . " : " . htmlspecialchars($produit->getPrix()) . "€</li>";
}
echo "</ul>";