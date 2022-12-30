<?php
namespace App\Bracket\Model\HTTP;

class Cookie {

    /**
     * Crée un cookie
     * @param string $cle
     * @param mixed $valeur
     * @param int|null $dureeExpiration
     * @return void
     */
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void {
        if ($dureeExpiration == null) setCookie($cle, serialize($valeur), 0);
        else setCookie($cle, serialize($valeur), time() + $dureeExpiration);
    }

    /**
     * Récupère un cookie
     * @param string $cle
     * @return mixed
     */
    public static function lire(string $cle) : mixed {
        return self::contient($cle) ? unserialize($_COOKIE[$cle]) : "";
    }

    /**
     * Contient le cookie
     * @param $cle
     * @return bool
     */
    public static function contient($cle) : bool {
        return isset($_COOKIE[$cle]);
    }

    /**
     * Supprime un cookie
     * @param $cle
     * @return void
     */
    public static function supprimer($cle) : void {
        unset($_COOKIE[$cle]);
        setcookie($cle, "", 1);
    }
}