<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <nav>

    </nav>
</header>
<main>
    <?php
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</main>
<footer>
    <p>Bracket</p>
</footer>
</body>
</html>

