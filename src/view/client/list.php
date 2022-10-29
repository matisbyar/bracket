<?php
/** @var Client $clients*/
foreach ($clients as $client) {
    $email = rawurlencode($client->getEmail());
    echo '<p>' . "<a href=?action=read&email=" . $email . ">Produit " . htmlspecialchars($client->getId()) . " ➤</a>  <button><a href=?action=update&email=" . $email . "> Modifier</a> </button>  <button><a href=?action=deleted&email=" . $email . "> Supprimer</a> </button></p>";
}
?>