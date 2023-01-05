<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\ConnexionClient;
use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Avis;
use App\Bracket\Model\Repository\AvisRepository;

class ControllerAvis extends GenericController
{
    public static function ajouterAvis(): void
    {
        if (ConnexionClient::estConnecte()) {
            if (isset($_REQUEST['idBijou']) && isset($_REQUEST['mailClient']) && isset($_REQUEST['note']) && isset($_REQUEST['avis'])) {
                $tableauFormulaire = $_REQUEST;
                $avis = Avis::construireDepuisFormulaire($tableauFormulaire);
                (new AvisRepository())->create($avis);
                MessageFlash::ajouter("success", "Votre avis a bien été ajouté, merci !");
                self::redirige("?controller=produit&action=read&id=" . $avis->getIdBijou());
            } else {
                MessageFlash::ajouter("danger", "Une erreur est survenue lors de l'ajout d'un avis, veuillez réessayer.");
                self::home();
            }
        } else {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour ajouter un avis !");
            self::redirige("?controller=produit&action=readAll");
        }
    }
}