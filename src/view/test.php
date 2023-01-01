<?php


use App\Bracket\Model\Repository\ProduitRepository;

var_dump($_POST);

echo "<br><br>";

var_dump((new ProduitRepository)::getDisponibles(105));