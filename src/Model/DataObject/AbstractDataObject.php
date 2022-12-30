<?php

namespace App\Bracket\Model\DataObject;

abstract class AbstractDataObject
{

    /**
     * Transforme l'objet en tableau associatif
     * @return array
     */
    public abstract function formatTableau(): array;

}