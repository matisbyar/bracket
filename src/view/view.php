<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
<link rel="stylesheet" href="/css/styles.css">
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
    <?php
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</main>
<footer>
    <!-- <p>Bracket — Bijouterie en ligne</p> -->
</footer>
</body>
</html>

