<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php use App\Bracket\Lib\ConnexionClient;
        use App\Bracket\Lib\MessageFlash;
    use App\Bracket\Model\Repository\ClientRepository;

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
        <a href="../web/index.php?action=home"><p class="logo">Bracket.</p></a>
        <div class="nav-raccourcis">
            <?php if (ConnexionClient::estAdministrateur()) { ?>
                <a href="../web/index.php?controller=client&action=admin"><p>Panel d'administration</p></a>
            <?php } ?>
            <a href="../web/index.php?action=readAllBracelets"><p>Bracelets</p></a>
            <a href="../web/index.php?action=readAllBagues"><p>Bagues</p></a>
            <?php if (ConnexionClient::estConnecte()) { ?>
                <a href="../web/index.php?controller=client&action=account">
                    <button class="lien"><img src="../images/account_login.svg" alt="Mon compte"></button>
                </a>
                <a href="../web/index.php?controller=client&action=account">
                    <p><?php echo (new ClientRepository())->getClientByEmail(ConnexionClient::getLoginUtilisateurConnecte())->getPrenom(); ?></p>
                </a>
                <a href="../web/index.php?controller=client&action=logout">
                    <button class="lien"><img src="../images/logout.svg" alt="Se déconnecter" ></button>
                </a>
            <?php } else { ?>
               <a href="../web/index.php?controller=client&action=login">
                        <button class="lien"><img src="../images/account_login.svg" alt="Se connecter/S'inscrire"></button>
                    </a>
            <?php } ?>
            <a href="../web/index.php?controller=panier&action=basket">
                <button class="lien"><img src="../images/basket.svg" alt="Panier"></button>
            </a>
        </div>
    </nav>
</header>
<main>
    <?php
    $messages = MessageFlash::lireTousMessages();
    foreach ($messages as $message) echo '<div class="alert alert-' . lcfirst($message["type"]) . '" role="alert">' . $message["message"] . '</div>';
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</main>
<footer>
    <div class="footer-container">
        <div class="footer-links">
            <ul>
                <li><a href="../web/index.php?action=aPropos">À propos de Bracket</a></li>
                <li><a href="../web/index.php?action=contact">Nous contacter</a></li>
                <?= ConnexionClient::estConnecte() ? '<li><a href="../web/index.php?controller=client&action=account">Mon compte</a></li>' : '<li><a href="../web/index.php?controller=client&action=login">S\'inscrire/Se connecter</a></li>' ?>
                <li><a href="../web/index.php?action=plan">Plan du site</a></li>
            </ul>
        </div>
        <div class="footer-copyright">
            <p>Bracket© 2023. Tous droits réservés</p>
        </div>
    </div>
</footer>
</body>
</html>

