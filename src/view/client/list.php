<?php
/** @var Client $clients*/
foreach ($clients as $client) {
    //var_dump($client);
    //$mail = rawurlencode($client->getEmail());
    echo '<p>'.'<a href="?controller=Client&action=read&email='.rawurldecode($client->getMail()).'">'.htmlspecialchars($client->getNom()).' '.htmlspecialchars($client->getPrenom()).
        '</a>'.' '.'<a href="?controller=Client&action=update&email='.rawurldecode($client->getMail()). '"> Modifier'.
        '</a>'.' '.'<a href="?controller=Client&action=delete&email='.rawurldecode($client->getMail()).'"> Supprimer'.'</a></p>';
}
?>