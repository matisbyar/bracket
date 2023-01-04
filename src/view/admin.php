<?php

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;

if (!ConnexionClient::estAdministrateur()) {
    MessageFlash::ajouter("danger", "Vous n'avez pas accès à cette page.");
    header("Location: ?action=home");
    exit();
}

?>

<body>
    <div class="admin-title">
        <h1>Administration</h1>
        <p>Retrouvez sur cette page, toutes les fonctions administratrices dont vous disposez pour rendre Bracket meilleur.</p>
    </div>
    <div class="admin-actions">
        <div class="admin-action">
            <a href="?action=readAll&controller=client">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/account_login-alt.svg">
                    <img class="admin-icon-hover" src="../images/account_login.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Gestion des clients</h2>
                </div>
            </a>
        </div>
        <div class="admin-action">
            <a href="?action=readAll&controller=produit&action=readAllBracelets">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/edit-alt.svg">
                    <img class="admin-icon-hover" src="../images/edit.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Gestion des bracelets</h2>
                </div>
            </a>
        </div>
        <div class="admin-action">
            <a href="?action=readAll&controller=produit&action=readAllBagues">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/edit-alt.svg">
                    <img class="admin-icon-hover" src="../images/edit.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Gestion des bagues</h2>
                </div>
            </a>
        </div>
        <div class="admin-action">
            <a href="?action=readAll&controller=produit&action=create">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/add-alt.svg">
                    <img class="admin-icon-hover" src="../images/add.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Ajouter un produit</h2>
                </div>
            </a>
        </div>
    </div>
</body>


