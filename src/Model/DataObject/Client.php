<?php

namespace App\Bracket\Model\DataObject;

use App\Bracket\Lib\MotDePasse;

class Client extends AbstractDataObject
{
    private string $mail, $nom, $prenom, $dateNaissance, $adresse, $password, $description;

    /**
     * @param string $mail
     * @param string $nom
     * @param string $prenom
     * @param string $dateNaissance
     * @param string $adresse
     * @param string $password
     * @param string $description
     */
    public function __construct(string $nom, string $prenom, string $dateNaissance, string $mail, string $adresse, string $password)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->mail = $mail;
        $this->adresse = $adresse;
        $this->password = $password;
        $this->description = "";
        // $this->description = $description;
    }

    public static function construireDepuisFormulaire(array $tableauFormulaire): Client
    {
        return new Client(
            $tableauFormulaire["nom"],
            $tableauFormulaire["prenom"],
            $tableauFormulaire["naissance"],
            $tableauFormulaire["mail"],
            $tableauFormulaire["adresse"],
            MotDePasse::hacher($tableauFormulaire["password"])
        );
    }
// TODO : problème avec le formatTableau
    public function formatTableau(): array
    {
        return array(
            "emailTag" => $this->getMail(),
            "nomTag" => $this->getNom(),
            "prenomTag" => $this->getPrenom(),
            "dateNaissanceTag" => $this->getDateNaissance(),
            "adresseTag" => $this->getAdresse(),
            "passwordTag" => $this->getPassword(),
            "descriptionTag" => $this->getDescription()
        );
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    /**
     * @param string $dateNaissance
     */
    public function setDateNaissance(string $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getMdpHache(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}