<?php
/** @var Client $clients;*/
echo '<p><strong>Client avec login/prénom/nom :</strong><ul>';
foreach ($clients as $client)
    echo '<li><p><a href="../web/index.php?controller=client&action=read&email='.
        rawurldecode($client->getMail()).'">' . htmlspecialchars($client->getMail()).' '.htmlspecialchars($client->getPrenom()).' '.htmlspecialchars($client->getNom()). '.</a> '
        .'<a href="../web/index.php?action=delete&email='.htmlspecialchars($client->getMail()).'&controller=client">Supprimer</a>'.' '.
        '<a href="../web/index.php?action=update&email='.htmlspecialchars($client->getMail()).'&controller=client">Mettre à jour</a></p></li>';

echo '</ul>';
?>
