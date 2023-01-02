<?php

namespace App\Bracket\Controller;

use App\Bracket\Lib\MessageFlash;
use App\Bracket\Model\DataObject\Avis;
use App\Bracket\Model\Repository\AvisRepository;

class ControllerAvis extends GenericController
{
    public static function ajouterAvis(): void
    {
        $tableauFormulaire = $_REQUEST;
        $avis = Avis::construireDepuisFormulaire($tableauFormulaire);
        (new AvisRepository())->save($avis);
        MessageFlash::ajouter("success", "Votre avis a bien été ajouté, merci !");
        self::redirige("?controller=produit&action=read&id=" . $avis->getIdBijou());
    }
}
{

}