<?php
/** @var Client $client */
echo 'Client :';
echo '<p><ul><li>Adresse mail : ' . htmlspecialchars($client->getMail()) .
    '</li><li>Nom : ' . htmlspecialchars($client->getNom()) .
    '</li><li>Prénom : ' . htmlspecialchars($client->getPrenom()) .
    '</li><li>Date de naissance : ' . htmlspecialchars($client->getDateNaissance()) .
    '</li><li>Adresse : ' . htmlspecialchars($client->getAdresse()) .
    '</li></ul></p>';
