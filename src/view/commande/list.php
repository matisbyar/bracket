<?php
/** @var Commande $commandes */
foreach ($commandes as $commande){
    echo "<p>Commande n°" . htmlspecialchars($commande->getId()) . " : <a href='index.php?controller=commande&action=read&id=" . htmlspecialchars($commande->getId()) . "'>Détail</a></p>";
}
