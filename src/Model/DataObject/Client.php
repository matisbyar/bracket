<?php

namespace App\Bracket\Model\DataObject;

use App\Bracket\Lib\MotDePasse;

class Client extends AbstractDataObject
{
    private string $mail, $nom, $prenom, $dateNaissance, $adresse, $password;
    private bool $estAdmin;

    /**
     * @param string $nom
     * @param string $prenom
     * @param string $dateNaissance
     * @param string $mail
     * @param string $adresse
     * @param string $password
     * @param boolean $estAdmin
     */
    public function __construct(string $mail, string $nom, string $prenom, string $dateNaissance, string $adresse, string $password,bool $estAdmin)
    {
        //var_dump($estAdmin);
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->mail = $mail;
        $this->adresse = $adresse;
        $this->password = $password;
        $this->estAdmin = $estAdmin;
    }

    public static function construireDepuisFormulaire(array $tableauFormulaire): Client
    {
        return new Client(
            $tableauFormulaire["mail"],
            $tableauFormulaire["nom"],
            $tableauFormulaire["prenom"],
            $tableauFormulaire["naissance"],
            $tableauFormulaire["adresse"],
            MotDePasse::hacher($tableauFormulaire["password"]),
            false
        );
    }

    public static function construireDepuisFormulaireAdmin(array $tableauFormulaire, string $password): Client
    {
        if($tableauFormulaire["estAdmin"]==null){
            return new Client(
                $tableauFormulaire["mail"],
                $tableauFormulaire["nom"],
                $tableauFormulaire["prenom"],
                $tableauFormulaire["naissance"],
                $tableauFormulaire["adresse"],
                $password,
                false
            );
        } else {
            return new Client(
                $tableauFormulaire["mail"],
                $tableauFormulaire["nom"],
                $tableauFormulaire["prenom"],
                $tableauFormulaire["naissance"],
                $tableauFormulaire["adresse"],
                $password,
                $tableauFormulaire["estAdmin"]
            );
        }
    }

    public function formatTableau(): array
    {
        return array(
            "emailTag" => $this->getMail(),
            "nomTag" => $this->getNom(),
            "prenomTag" => $this->getPrenom(),
            "dateNaissanceTag" => $this->getDateNaissance(),
            "adresseTag" => $this->getAdresse(),
            "passwordTag" => $this->getMdpHache(),
            "estAdminTag"=> $this->getEstAdmin(),
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
     * @return bool
     */
    public function isEstAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function getEstAdmin() : int
    {
        if($this->estAdmin) return 1;
        else return 0;
    }

    /**
     * @param bool $estAdmin
     */
    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }
}