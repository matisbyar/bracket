<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php use App\Bracket\Lib\ConnexionClient;
        use App\Bracket\Lib\MessageFlash;
        /* @var $cheminVueBody
         * @var $pagetitle*/?>
    <title><?php echo $pagetitle; ?></title>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <nav>
        <a href="../web/frontController.php?action=home"><p class="logo">Bracket.</p></a>
        <div class="nav-raccourcis">
            <a href="../web/frontController.php?action=readAllBracelets"><p>Bracelets</p></a>
            <a href="../web/frontController.php?action=readAllBagues"><p>Bagues</p></a>
            <?php if (ConnexionClient::estConnecte()) { ?>
                <a href="../web/frontController.php?controller=client&action=account">
                        <button class="lien"><img src="../images/account_login.svg" alt="Fav"></button>
                    </a>
               <a href="../web/frontController.php?controller=client&action=logout">
                        <button class="lien"><img src="../images/logout.svg" alt="Fav" ></button>
                    </a>
            <?php } else { ?>
               <a href="../web/frontController.php?controller=client&action=login">
                        <button class="lien"><img src="../images/account_login.svg" alt="Fav"></button>
                    </a>
            <?php } ?>
            <a href="../web/frontController.php?controller=client&action=basket">
                <button class="lien"><img src="../images/basket.svg" alt="Fav"></button>
            </a>
        </div>
    </nav>
</header>
<main>
    <?php
    $messages = MessageFlash::lireTousMessages();
    foreach ($messages as $message) echo '<div class="alert alert-' . $message["type"] . '" role="alert">' . $message["message"] . '</div>';
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</main>
<footer>
    <div class="footer-container">
        <div class="footer-links">
            <ul>
                <li><a href="../web/frontController.php?action=aPropos">À propos de Bracket</a></li>
                <li><a href="../web/frontController.php?action=contact">Nous contacter</a></li>
                <?= ConnexionClient::estConnecte() ? '<li><a href="../web/frontController.php?controller=client&action=account">Mon compte</a></li>' : '<li><a href="../web/frontController.php?controller=client&action=login">S\'inscrire/Se connecter</a></li>' ?>
                <li><a href="../web/frontController.php?action=plan">Plan du site</a></li>
            </ul>
        </div>
        <div class="footer-copyright">
            <p>Bracket© 2023. Tous droits réservés</p>
        </div>
    </div>
</footer>
</body>
</html>

