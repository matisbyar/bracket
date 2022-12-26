<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php use App\Bracket\Lib\ConnexionUtilisateur;
        use App\Bracket\Lib\MessageFlash;?>
    <title><?php echo $pagetitle; ?></title>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css"/>
</head>
<body>
<header>
    <nav>
        <a href="../web/frontController.php?action=home"><p class="logo">Bracket.</p></a>
        <div class="nav-raccourcis">
            <a href="../web/frontController.php?action=readAllBracelets"><p>Bracelets</p></a>
            <a href="../web/frontController.php?action=readAllBagues"><p>Bagues</p></a>
            <?php if (ConnexionUtilisateur::estConnecte()) { ?>
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
</footer>
</body>
</html>

