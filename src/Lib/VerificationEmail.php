<?php

namespace App\Bracket\Lib;

use App\Bracket\Config\Conf;
use App\Bracket\Model\DataObject\Client;
use App\Bracket\Model\Repository\ClientRepository;

class VerificationEmail
{

    public static function envoiEmailValidation(Client $client): void
    {
        $loginURL = rawurlencode($client->getMail());
        $nonceURL = rawurlencode($client->getNonce());
        $absoluteURL = Conf::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=validerEmail&controller=client&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation de votre email</a>";

        // Temporairement avant d'envoyer un vrai mail
        MessageFlash::ajouter("info", $corpsEmail);
        // mail($utilisateur->getEmail(), "Validation de votre email", "Votre email a été validé.");
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        $client = (new ClientRepository())->select($login);
        if ($client != null) {
            if ($client->getNonce() == $nonce) {
                $client->setMailValide(true);
                $client->setNonce("");
                (new ClientRepository())->update($client);
                return true;
            }
        }
        return false;
    }

    /**
     * @param Client $client
     * @return bool vrai si le mail est à valider. Faux sinon.
     */
    public static function aValideEmail(Client $client): bool
    {
        return !$client->isMailValide();
    }
}