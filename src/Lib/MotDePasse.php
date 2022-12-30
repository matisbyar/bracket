<?php

namespace App\Bracket\Lib;

use Exception;

class MotDePasse
{

    // Le $poivre représente une chaîne de caractères aléatoire qui sera ajoutée au mot de passe avant de le hacher.
    private static string $poivre = "LWQBen/Jdo+L/yybZudJ1p";

    /**
     * Retourne le mot de passe haché
     * @param string $mdpClair
     * @return string
     */
    public static function hacher(string $mdpClair): string
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        $mdpHache = password_hash($mdpPoivre, PASSWORD_DEFAULT);
        return $mdpHache;
    }

    /**
     * Retourne si le mot de passe donner par l'utilisateur est identique au mot de passe haché
     * @param string $mdpClair
     * @param string $mdpHache
     * @return bool
     */
    public static function verifier(string $mdpClair, string $mdpHache): bool
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        return password_verify($mdpPoivre, $mdpHache);
    }

    /**
     * Generer un mot de passe aléatoire
     * @param int $nbCaracteres
     * @return string
     * @throws Exception
     */
    public static function genererChaineAleatoire(int $nbCaracteres = 22): string
    {
        // 22 caractères par défaut pour avoir au moins 128 bits aléatoires
        // 1 caractère = 6 bits car 64=2^6 caractères en base_64
        // et 128 <= 22*6 = 132
        $octetsAleatoires = random_bytes(ceil($nbCaracteres * 6 / 8));
        return substr(base64_encode($octetsAleatoires), 0, $nbCaracteres);
    }
}
