<?php

namespace App\Bracket\Model\DataObject;

use App\Bracket\Lib\MotDePasse;

class Client extends AbstractDataObject
{
    private string $mail, $nom, $prenom, $dateNaissance, $adresse, $password, $nonce;
    private bool $estAdmin, $mailValide;

    /**
     * Constructeur
     * @param string $mail
     * @param string $nom
     * @param string $prenom
     * @param string $dateNaissance
     * @param string $adresse
     * @param string $password
     * @param bool $estAdmin
     * @param bool $mailValide
     * @param string $nonce
     */
    public function __construct(string $mail, string $nom, string $prenom, string $dateNaissance, string $adresse, string $password, bool $estAdmin, bool $mailValide, string $nonce)
    {
        $this->mail = $mail;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->adresse = $adresse;
        $this->password = $password;
        $this->estAdmin = $estAdmin;
        $this->mailValide = $mailValide;
        $this->nonce = $nonce;
    }

    /**
     * Construit un objet Client à partir d'un tableau de données
     * @param array $tableauFormulaire
     * @return Client
     * @throws \Exception
     */
    public static function construireDepuisFormulaire(array $tableauFormulaire): Client
    {
        return new Client(
            $tableauFormulaire["mail"],
            $tableauFormulaire["nom"],
            $tableauFormulaire["prenom"],
            $tableauFormulaire["naissance"],
            $tableauFormulaire["adresse"],
            MotDePasse::hacher($tableauFormulaire["password"]),
            isset($tableauFormulaire["estAdmin"]),
            true,
            MotDePasse::genererChaineAleatoire()
        );
    }

    /**
     * Transforme l'objet en tableau associatif
     * @return array
     */
    public function formatTableau(): array
    {
        return array(
            "emailTag" => $this->getMail(),
            "nomTag" => $this->getNom(),
            "prenomTag" => $this->getPrenom(),
            "dateNaissanceTag" => $this->getDateNaissance(),
            "adresseTag" => $this->getAdresse(),
            "passwordTag" => $this->getMdpHache(),
            "estAdminTag" => $this->getEstAdmin(),
            "mailValideTag" => $this->isMailValide(),
            "nonceTag" => $this->getNonce()
        );
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getMdpHache(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function estAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function getEstAdmin(): int
    {
        return $this->estAdmin ? 1 : 0;
    }

    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }

    public function isMailValide(): int
    {
        return $this->mailValide ? 1 : 0;
    }

    public function setMailValide(bool $mailValide): void
    {
        $this->mailValide = $mailValide;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
    }
}