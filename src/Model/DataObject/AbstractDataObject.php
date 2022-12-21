<?php

namespace App\Bracket\Model\DataObject;

abstract class AbstractDataObject {

    public abstract function formatTableau(AbstractDataObject $object): array;

}