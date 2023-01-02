<?php

namespace App\Bracket\Model\DataObject;


class Avis extends AbstractDataObject
{

    private int $idBijou, $note;
    private string $mailClient, $avis;

    public function __construct(int $idBijou, string $mailClient, int $note, string $avis)
    {
        $this->idBijou = $idBijou;
        $this->mailClient = $mailClient;
        $this->note = $note;
        $this->avis = $avis;
    }

    public function formatTableau(): array
    {
        return array(
            "idBijouTag" => $this->getIdBijou(),
            "mailClientTag" => $this->getMailClient(),
            "noteTag" => $this->getNote(),
            "avisTag" => $this->getAvis()
        );
    }

    public static function construireDepuisFormulaire(array $tableauFormulaire): Avis
    {
        return new Avis(
            $tableauFormulaire["idBijou"],
            $tableauFormulaire["mailClient"],
            $tableauFormulaire["note"],
            $tableauFormulaire["avis"]
        );
    }

    public function getIdBijou(): int
    {
        return $this->idBijou;
    }

    public function setIdBijou(int $idBijou): void
    {
        $this->idBijou = $idBijou;
    }

    public function getMailClient(): string
    {
        return $this->mailClient;
    }

    public function setMailClient(string $mailClient): void
    {
        $this->mailClient = $mailClient;
    }

    public function getAvis(): string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): void
    {
        $this->avis = $avis;
    }

    public function getNote(): int
    {
        return $this->note;
    }

    public function setNote(int $note): void
    {
        $this->note = $note;
    }
}