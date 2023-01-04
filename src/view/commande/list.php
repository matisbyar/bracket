<?php
/** @var Commande $commandes */
foreach ($commandes as $commande){
    echo "<section>";
    echo "<p>".$commande->getId()."</p>";
    echo "<p>".$commande->getAdresse()."</p>";
    echo "<p>".$commande->getClient()."</p>";
    echo "<ul>";
    foreach ($commande->getProduits() as $produit){
        echo "<li>";
        echo "<p>". $produit->getNom()."</p>";
        echo "</li>";
    }
    echo "</ul>";
    echo "</section>";
}