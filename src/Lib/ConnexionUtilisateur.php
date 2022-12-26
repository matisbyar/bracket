<?php

namespace App\Bracket\Lib;

use App\Bracket\Model\HTTP\Session;
use App\Bracket\Model\Repository\ClientRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        // À compléter
        Session::getInstance()->enregistrer(self::$cleConnexion, $loginUtilisateur);
        var_dump(Session::getInstance()->lire(self::$cleConnexion));
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(self::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        return Session::getInstance()->lire(self::$cleConnexion);
    }

    public static function estUtilisateur($login): bool
    {
        return self::getLoginUtilisateurConnecte() === $login;
    }

    public static function estAdministrateur() : bool
    {
        if(self::estConnecte()){
            $user = (new ClientRepository)->read(self::getLoginUtilisateurConnecte());
            if(self::estConnecte() && $user->estAdmin()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
?>