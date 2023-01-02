<div class="login-title">
    <h1>Plan du site</h1>
    <p>Histoire de pas vous perdre.</p>
</div>
<div class="plan">
    <div class="plan-section">
        <h2>Accueil</h2>
        <ul>
            <li><a href="?action=home">Accueil</a></li>
            <li><a href="?action=plan">Plan du site</a></li>
            <li><a href="?action=contact">Contact</a></li>
            <li><a href="?action=aPropos">À propos</a></li>
        </ul>
    </div>
    <div class="plan-section">
        <h2>Produits</h2>
        <ul>
            <li><a href="?action=readAllBracelets">Bracelets</a></li>
            <li><a href="?action=readAllBagues">Bagues</a></li>
            <li><a href="?action=readAll">Tous les produits</a></li>
        </ul>
    </div>
    <div class="plan-section">
        <h2>Compte</h2>
        <ul>
            <li><a href="?controller=client&action=login">Se connecter/S'inscrire</a></li>
            <?php
            use App\Bracket\Lib\ConnexionClient;
            if (ConnexionClient::estConnecte()) {
                echo '<li><a href="?controller=client&action=account">Mon compte</a></li>
                <li><a href="?controller=client&action=logout">Se déconnecter</a></li>';
            } else {
                echo '<li><a href="?controller=client&action=login">Se connecter/S\'inscrire</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="plan-section">
        <h2>Panier</h2>
        <ul>
            <li><a href="?controller=client&action=basket">Mon panier</a></li>
            <li><a href="?controller=client&action=checkout">Commander</a></li>
        </ul>
    </div>
</div>