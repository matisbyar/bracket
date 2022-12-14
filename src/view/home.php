<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Accueil — Bracket.</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <nav>
        <a href="/web/frontController.php?action=home"><p class="logo">Bracket.</p></a>
        <div class="nav-raccourcis">
            <a href="/web/frontController.php?action=readAllBracelets"><p>Bracelets</p></a>
            <a href="/web/frontController.php?action=readAllBagues"><p>Bagues</p></a>
        </div>
    </nav>
</header>
<main>
    <div class="starred">
        <div class="starred-gauche">
            <img src="../images/<?php echo $produitALaUne->getId(); ?>.png" alt="Produit à l'affiche">
        </div>
        <div class="starred-droite">
            <small>À L'AFFICHE</small>
            <h1><?php echo $produitALaUne->getNom(); ?></h1>
            <h2><?php echo $produitALaUne->getMateriau() . " — " . $produitALaUne->getPrix() . "€"; ?></h2>
            <p>
                <?php echo $produitALaUne->getDescription();  ?>
            </p>
            <div class="starred-buttons">
                <button id="en-savoir-plus"><a href="?action=read&id=<?php echo $produitALaUne->getId(); ?>">EN SAVOIR PLUS</a></button>
                <button id="acheter">ACHETER</button>
            </div>
        </div>
    </div>

    <h1>Les classiques</h1>
    <?php
    use App\Bracket\Lib\MessageFlash;
    $messages = MessageFlash::lireTousMessages();
    foreach ($messages as $message) {
        echo '<div class="alert alert-' . $message["type"] . '" role="alert">' . $message["message"] . '</div>';
    }
    require "produit/list.php";
    ?>

    <h1>Les nouveautés</h1>
    <small><a href="/web/frontController.php?action=readAll">VOIR PLUS ></a></small>
</main>
<footer>
    <!-- <p>Bracket — Bijouterie en ligne</p> -->
</footer>
</body>
</html>

