<?php

namespace App\Bracket\Lib;

use App\Bracket\Model\HTTP\Session;

class MessageFlash
{
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    /**
     * Ajout d'un message flash
     * $type parmi "success", "info", "warning" ou "danger"
     * @param string $type
     * @param string $message
     * @return void
     */
    public static function ajouter(string $type, string $message): void
    {
        $messages = Session::getInstance()->contient(self::$cleFlash) ? Session::getInstance()->lire(self::$cleFlash) : [];
        $messages[] = ["type" => $type, "message" => $message];
        Session::getInstance()->enregistrer(self::$cleFlash, $messages);
    }

    /**
     * Retourne si le message flash contient le message en paramètre
     * @param string $type
     * @return bool
     */
    public static function contientMessage(string $type): bool
    {
        $messages = Session::getInstance()->contient(self::$cleFlash) ? Session::getInstance()->lire(self::$cleFlash) : [];
        foreach ($messages as $message) {
            if ($message["type"] === $type) return true;
        }
        return false;
    }

    /**
     * Permet de récupérer le messages flash
     * Attention : la lecture doit détruire le message
     * @param string $type
     * @return array
     */
    public static function lireMessages(string $type): array
    {
        $messages = Session::getInstance()->contient(self::$cleFlash) ? Session::getInstance()->lire(self::$cleFlash) : [];
        $messagesRetour = [];
        foreach ($messages as $message) {
            if ($message["type"] === $type) $messagesRetour[] = $message["message"];
        }
        Session::getInstance()->supprimer(self::$cleFlash);
        return $messagesRetour;
    }

    /**
     * Permet de récupérer tous les messages flash
     * @return array
     */
    public static function lireTousMessages(): array
    {
        $messages = Session::getInstance()->contient(self::$cleFlash) ? Session::getInstance()->lire(self::$cleFlash) : [];
        Session::getInstance()->supprimer(self::$cleFlash);
        return $messages;
    }
}