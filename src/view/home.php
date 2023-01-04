<link rel="stylesheet" href="../css/styles.css"/>
<div class="starred">
    <div class="starred-gauche">
        <img class="imageAffiche" src="<?php echo $produitALaUne->getImage(); ?>" alt="Produit à l'affiche">
    </div>
    <div class="starred-droite">
        <small>À L'AFFICHE</small>
        <h1><?php echo $produitALaUne->getNom(); ?></h1>
        <h2><?php echo $produitALaUne->getMateriau() . " — " . $produitALaUne->getPrix() . "€"; ?></h2>
        <p>
            <?php echo $produitALaUne->getDescription(); ?>
        </p>
        <div class="starred-buttons">
            <button id="enSavoirPlus"><a href="?action=read&id=<?php echo $produitALaUne->getId(); ?>">EN SAVOIR PLUS</a></button>
            <button id="acheter">ACHETER</button>
        </div>
    </div>
</div>

<div class="titres-home">
    <h1 class="titre-home">Les classiques</h1>
    <a class="sous-titre-home" href="?controller=produit&action=readAll">Voir plus</a>
    <i class="fa-solid fa-arrow-left"></i>
</div>
<?php

use App\Bracket\Lib\MessageFlash;
use App\Bracket\Lib\ConnexionClient;

$messages = MessageFlash::lireTousMessages();
foreach ($messages as $message) {
    echo '<div class="alert alert-' . $message["type"] . '" role="alert">' . $message["message"] . '</div>';
}
require "produit/list.php";
?>