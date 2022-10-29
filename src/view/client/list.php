<?php
/** @var Client $clients*/
foreach ($clients as $client) {
    //var_dump($client);
    //$mail = rawurlencode($client->getEmail());
    echo '<p>'.'<a href="?read&email="'.rawurldecode($client->getMail()).'>'.htmlspecialchars($client->getNom()).' '.htmlspecialchars($client->getPrenom()).
        '</a>'.' '.'<a href="?action=update&email="'.rawurldecode($client->getMail()). '> Modifier'.
        '</a>'.' '.'<a href="?action=delete&email="'.rawurldecode($client->getMail()).'> Supprimer'.'</a></p>';
}
?>