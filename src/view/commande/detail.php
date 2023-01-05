<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Model\DataObject\Commande;
use App\Bracket\Model\Repository\ProduitRepository;
/** @var Commande $commande */
echo "<section>";
echo "<h2>Commande n°" . htmlspecialchars($commande->getId()) . "</h2>";
echo "Livré à : " . htmlspecialchars($commande->getAdresse()) . "<br>";
if (ConnexionClient::estAdministrateur()) {
    echo "Commande passé par : " . htmlspecialchars($commande->getClient()) . "<br>";
    echo "Statut : " . htmlspecialchars($commande->getStatut()) . "<br>";
}
echo "Liste des produits : ";
echo "<ul>";
foreach ($commande->getArticles() as $article) {
    $bijou = (new ProduitRepository)->select($article->getIdBijou());
    if (ConnexionClient::estAdministrateur()){
        echo "<li>" . htmlspecialchars($bijou->getNom()) . " : " . htmlspecialchars($bijou->getPrix()) . "€" .
            "<a href='index.php?controller=commande&action=validerCommande&id=" . htmlspecialchars($commande->getId()) . "'> Valider la commande </a>".
            "<a href='index.php?controller=commande&action=annulerCommande&id=" . htmlspecialchars($commande->getId()) . "'>Annuler</a></li>";
    }else{
        echo "<li>" . htmlspecialchars($bijou->getNom()) . " : " . htmlspecialchars($bijou->getPrix()) . "€</li>";
    }
}
echo "</ul>";

if (!ConnexionClient::estAdministrateur()){
    echo "<a href='index.php?controller=commande&action=recommander&id=" . htmlspecialchars($commande->getId()) . "'>Recommander</a>";
}