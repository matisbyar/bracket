<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php use App\Bracket\Lib\ConnexionUtilisateur;
        use App\Bracket\Lib\MessageFlash;

        echo $pagetitle; ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <nav>
        <a href="../web/frontController.php?action=home"><p class="logo">Bracket.</p></a>
        <div class="nav-raccourcis">
            <a href="../web/frontController.php?action=readAllBracelets"><p>Bracelets</p></a>
            <a href="../web/frontController.php?action=readAllBagues"><p>Bagues</p></a>
            <?php if (ConnexionUtilisateur::estConnecte()) { ?>
                <li><a href="../web/frontController.php?action=account">
                        <button>account<img src="../../images/person.svg" alt="Fav" style="width:30px;height:30px;"></button>
                    </a></li>
                <li><a href="../web/frontController.php?action=logout">
                        <button>logout<img src="../../images/person.svg" alt="Fav" style="width:30px;height:30px;"></button>
                    </a></li>
            <?php } else { ?>
                <li><a href="../web/frontController.php?action=login">
                        <button>login<img src="../../images/person.svg" alt="Fav" style="width:30px;height:30px;"></button>
                    </a></li>
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
    <!-- <p>Bracket — Bijouterie en ligne</p> -->
</footer>
</body>
</html>

