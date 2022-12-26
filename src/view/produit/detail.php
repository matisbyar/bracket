<?php
use App\Bracket\Lib\ConnexionUtilisateur;
/** @var Produit $produit */

?>
    <div class="back-btn">
        <button onclick="history.go(-1);"><i class="fas fa-arrow-left"><img src="../images/backPage.svg" alt="button retour"></i></button>
    </div>
<?php

echo '<h1 class="h1Description">' . ucfirst($produit->getType()) . '</h1>';

/* Image */
echo '<section class="imageAfficheDescription">';
echo '<img class="imageDescription" src="' . $produit->getImage() . '" alt="Image du bracelet">';
echo '</section>';

/* Description */

echo '<section class="description">';
echo '<div>'. '- ' . $produit->getNom() . '</div>';
echo '<div>'. '- ' . $produit->getMateriau() . '</div>';
echo '<div>'. '- ' . $produit->getDescription() . '</div>';
echo '<div class="lastDesc">' . $produit->getPrix() . ' € </div>';
if (ConnexionUtilisateur::estAdministrateur()){
    echo "<div><a href=\"?action=update&controller=produit&id=".$produit->getId()."\">Modifier le produit</a></div>";
}
echo '</section>';
?>