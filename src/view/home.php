<link rel="stylesheet" href="../css/styles.css"/>
<div class="starred">
    <div class="starred-gauche">
        <img class="imageAffiche" src="../images/<?php echo $produitALaUne->getId(); ?>.png" alt="Produit à l'affiche">
    </div>
    <div class="starred-droite">
        <small>À L'AFFICHE</small>
        <h1><?php echo $produitALaUne->getNom(); ?></h1>
        <h2><?php echo $produitALaUne->getMateriau() . " — " . $produitALaUne->getPrix() . "€"; ?></h2>
        <p>
            <?php echo $produitALaUne->getDescription(); ?>
        </p>
        <div class="starred-buttons">
            <button id="enSavoirPlus"><a href="?action=read&id=<?php echo $produitALaUne->getId(); ?>">EN SAVOIR
                    PLUS</a></button>
            <button id="acheter">ACHETER</button>
        </div>
    </div>
</div>

<h1 class="ClassiqueHome">Les classiques</h1>
<?php

use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\ConnexionUtilisateur;

$messages = MessageFlash::lireTousMessages();
foreach ($messages as $message) {
    echo '<div class="alert alert-' . $message["type"] . '" role="alert">' . $message["message"] . '</div>';
}
require "produit/list.php";

if(ConnexionUtilisateur::estAdministrateur()){
    echo "<a href=\"?action=create&controller=produit\">Créer un bijou</a>";
}
?>
<h1>Les nouveautés</h1>
<small><a href="?action=readAll">VOIR PLUS ></a></small>
<img src="https://upload.wikimedia.org/wikipedia/commons/8/85/Logo-Test.png" alt="Test">
