<?php

namespace App\Bracket\Model\Repository;
use App\Bracket\Model\DataObject\Client;

class ClientRepository extends AbstractRepository {
    public function construire(array $clientFormatTableau) : Client {
        return new Client($clientFormatTableau['0'], $clientFormatTableau['1'], $clientFormatTableau['2'], $clientFormatTableau['3'], $clientFormatTableau['4'], $clientFormatTableau['5'], $clientFormatTableau["6"], $clientFormatTableau['7'], $clientFormatTableau["8"]);
    }

    protected function getNomTable(): string {
        return "p_clients";
    }

    protected function getNomClePrimaire(): string {
        return "email";
    }

    protected function getNomColonnes(): array
    {
        return array(
            "email", "nom", "prenom", "dateNaissance", "adresse", "password", "estAdmin", "mailValide", "nonce"
        );
    }
}