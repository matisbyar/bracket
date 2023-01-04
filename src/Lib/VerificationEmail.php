<?php

namespace App\Bracket\Lib;

use App\Bracket\Config\Conf;
use App\Bracket\Model\DataObject\Client;
use App\Bracket\Model\Repository\ClientRepository;

class VerificationEmail
{

    /**
     * Envoie le mail entré pour validation
     * @param Client $client
     * @return void
     */
    public static function envoiEmailValidation(Client $client): void
    {
        $loginURL = rawurlencode($client->getMail());
        $nonceURL = rawurlencode($client->getNonce());
        $absoluteURL = Conf::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=validerEmail&controller=client&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation de votre email</a>";

        if (substr($client->getMail(), -10) == "@yopmail.com") {
            MessageFlash::ajouter("info", "Un lien de validation a été envoyé à l'adresse $lienValidationEmail");
            mail($client->getMail(), "Validation de votre email", wordwrap("Bonjour très cher(e) Validez votre email ici:" . $corpsEmail, 70, "\r\n"));
        } else {
            MessageFlash::ajouter("info", $corpsEmail);
        }
    }

    /**
     * Traite la validation de l'email
     * @param string $login
     * @param string $nonce
     * @return bool
     */
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
     * Retourne si l'email est validé
     * @param Client $client
     * @return bool vrai si le mail est à valider. Faux sinon.
     */
    public static function aValideEmail(Client $client): bool
    {
        return !$client->isMailValide();
    }
}