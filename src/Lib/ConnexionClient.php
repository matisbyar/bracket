<?php

namespace App\Bracket\Lib;

use App\Bracket\Model\HTTP\Session;
use App\Bracket\Model\Repository\ClientRepository;

class ConnexionClient
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    /**
     * Connexion d'un utilisateur
     * @param string $loginUtilisateur
     * @return void
     */
    public static function connecter(string $loginUtilisateur): void
    {
        // À compléter
        Session::getInstance()->enregistrer(self::$cleConnexion, $loginUtilisateur);
    }

    /**
     * Retourne si l'utilisateur est connecté
     * @return bool
     */
    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(self::$cleConnexion);
    }

    /**
     * Decoonection d'un utilisateur
     * @return void
     */
    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(self::$cleConnexion);
    }

    /**
     * Retourne le login de l'utilisateur connecté
     * @return ?string
     */
    public static function getLoginUtilisateurConnecte(): ?string
    {
        return Session::getInstance()->lire(self::$cleConnexion);
    }

    /**
     * Retourne si c'est bien l'utilisateur connecté
     * @return bool
     */
    public static function estUtilisateur($login): bool
    {
        return self::getLoginUtilisateurConnecte() === $login;
    }

    /**
     * Retourne si l'utilisateur connecté est un administrateur
     * @return bool
     */
    public static function estAdministrateur(): bool
    {
        return self::estConnecte() && (new ClientRepository())->select(self::getLoginUtilisateurConnecte())->estAdmin();
    }
}

?>