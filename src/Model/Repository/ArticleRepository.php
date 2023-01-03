<?php

namespace App\Bracket\Model\Repository;

use App\Bracket\Model\DataObject\AbstractDataObject;
use App\Bracket\Model\DataObject\Article;

class ArticleRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "p_articles";
    }

    protected function construire(array $objetFormatTableau): Article
    {
        return new Article(
            $objetFormatTableau["idBijou"],
            $objetFormatTableau["stock"],
            $objetFormatTableau["couleur"],
            $objetFormatTableau["taille"]
        );
    }

    protected function getNomClePrimaire(): string
    {
        return "idBijou";
    }

    protected function getNomColonnes(): array
    {
        return array("idBijou", "stock", "couleur", "taille");
    }
}