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
            <a href="?controller=produit&action=readAllBracelets">
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
            <a href="?controller=produit&action=readAllBagues">
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
            <a href="?controller=produit&action=create">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/add-alt.svg">
                    <img class="admin-icon-hover" src="../images/add.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Créer une fiche produit</h2>
                </div>
            </a>
        </div>
        <div class="admin-action">
            <a href="?controller=produit&action=delete">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/delete-alt.svg">
                    <img class="admin-icon-hover" src="../images/delete.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Supprimer une fiche produit</h2>
                    <p><strong>Attention !</strong> Cette action supprimera tous les articles définis.</p>
                </div>
            </a>
        </div>
        <div class="admin-action">
            <a href="?controller=article&action=create">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/add-alt.svg">
                    <img class="admin-icon-hover" src="../images/add.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Ajouter un article</h2>
                </div>
            </a>
        </div>
        <div class="admin-action">
            <a href="?controller=commande&action=commande">
                <div class="admin-action-icon">
                    <img class="admin-icon" src="../images/basket-alt.svg">
                    <img class="admin-icon-hover" src="../images/basket.svg">
                </div>
                <div class="admin-action-title">
                    <h2>Commande</h2>
                </div>
            </a>
        </div>
    </div>
</body>


