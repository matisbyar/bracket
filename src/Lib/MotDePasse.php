<?php

namespace App\Bracket\Lib;

class MotDePasse
{

    // Exécutez genererChaineAleatoire() et stockez sa sortie dans le poivre
    private static string $poivre = "LWQBen/Jdo+L/yybZudJ1p";

    public static function hacher(string $mdpClair): string
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        $mdpHache = password_hash($mdpPoivre, PASSWORD_DEFAULT);
        return $mdpHache;
    }

    public static function verifier(string $mdpClair, string $mdpHache): bool
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        return password_verify($mdpPoivre, $mdpHache);
    }

    public static function genererChaineAleatoire(int $nbCaracteres = 22): string
    {
        // 22 caractères par défaut pour avoir au moins 128 bits aléatoires
        // 1 caractère = 6 bits car 64=2^6 caractères en base_64
        // et 128 <= 22*6 = 132
        $octetsAleatoires = random_bytes(ceil($nbCaracteres * 6 / 8));
        return substr(base64_encode($octetsAleatoires), 0, $nbCaracteres);
    }

    public static function motDePasseValide(string $mdp) : bool
    {
        //créer un tableau de caractères spéciaux
        $specialChars = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "=", "[", "]", "{", "}", "|", ";", ":", "'", '"', "<", ">", ",", ".", "?", "/");
        //créer un tableau de chiffres
        $numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        //créer un tableau de lettres majuscules
        $majLetters = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        //créer un tableau de lettres minuscules
        $minLetters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        //créer un tableau de caractères
        $chars = array_merge($specialChars, $numbers, $majLetters, $minLetters);
        //créer un tableau de caractères du mot de passe
        $mdpChars = str_split($mdp);
        //vérifier que le mdp contient au moins un caractère spécial, un chiffre, une lettre majuscule et une lettre minuscule et a une longueur de 8 caractères minimum
        if (count(array_intersect($specialChars, $mdpChars)) > 0 && count(array_intersect($numbers, $mdpChars)) > 0 && count(array_intersect($majLetters, $mdpChars)) > 0 && count(array_intersect($minLetters, $mdpChars)) > 0 && count($mdpChars) >= 8) {
            return true;
        } else {
            return false;
        }
    }
}

// Pour créer votre poivre (une seule fois)
// var_dump(MotDePasse::genererChaineAleatoire());
