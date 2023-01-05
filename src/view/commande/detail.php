<?php
  use App\Bracket\Model\Repository\ProduitRepository;
/** @var Commande $commande */
echo "<section>";
echo "<h2>Commande n°" . htmlspecialchars($commande->getId()) . "</h2>";
echo "Livré à : " . htmlspecialchars($commande->getAdresse()) . "<br>";
echo "Liste des produits : ";
echo "<ul>";
foreach ($commande->getArticles() as $article) {
    $bijou = (new ProduitRepository)->select($article->getIdBijou());
    echo "<li>" . htmlspecialchars($bijou->getNom()) . " : " . htmlspecialchars($bijou->getPrix()) . "€</li>";
}
echo "</ul>";

echo "<a href='index.php?controller=commande&action=recommander&id=" . htmlspecialchars($commande->getId()) . "'>Recommander</a>";