<?php
/** @var Utilisateur $utilisateurs;*/
echo '<p><strong>Utilisateur avec login/prénom/nom :</strong><ul>';
foreach ($clients as $client)
    echo '<li><p><a href="../web/frontController.php?controller=utilisateur&action=read&login='.
        rawurlencode($client->getMail()).'">' . htmlspecialchars($client->getMail()).' '.htmlspecialchars($client->getPrenom()).' '.htmlspecialchars($client->getNom()). '.</a> '
        .'<a href="../web/frontController.php?action=delete&email='.htmlspecialchars($client->getMail()).'&controller=client">Supprimer</a>'.' '.
        '<a href="../web/frontController.php?action=update&email='.htmlspecialchars($client->getMail()).'&controller=client">Mettre à jour</a></p></li>';

echo '</ul>';
?>
