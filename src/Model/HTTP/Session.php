<?php
namespace App\Bracket\Model\HTTP;

use App\Bracket\Config\Conf;
use App\Bracket\Lib\MessageFlash;
use Exception;

class Session {
    private static ?Session $instance = null;

    /**
     * Constructeur privé
     * @throws Exception
     */
    private function __construct() {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    /**
     * Retourne l'instance de la classe
     * @return Session
     */
    public static function getInstance(): Session {
        if (is_null(static::$instance)) static::$instance = new Session();
        self::$instance->verifierDerniereActivite();
        return static::$instance;
    }

    /**
     * Vérifie si la dernière activité est trop ancienne
     * @param $name
     * @return bool
     */
    public function contient($name): bool {
        return isset($_SESSION[$name]);
    }

    /**
     * Enregistre une valeur en session
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function enregistrer(string $name, mixed $value): void {
        if (!isset($_SESSION)) session_start();
        $_SESSION[$name] = $value;
    }

    /**
     * Récupère une valeur en session
     * @param string $name
     * @return mixed
     */
    public function lire(string $name): mixed {
        return $_SESSION[$name];
    }

    /**
     * Supprime une valeur en session
     * @param $name
     * @return void
     */
    public function supprimer($name): void {
        unset($_SESSION[$name]);
    }

    /**
     * Détruit la session
     * @return void
     */
    public function detruire() : void {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
        // Il faudra reconstruire la session au prochain appel de getInstance()
        $instance = null;
    }

    /**
     * Vérifie si la dernière activité est trop ancienne
     * @return void
     */
    public function verifierDerniereActivite(): void {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > Conf::getDureeSession())) {
            // last request was more than 30 minutes ago
            $this->detruire();   // destroy session data in storage
            MessageFlash::ajouter("warning", "Votre session est échue. " . '<a href="?controller=client&action=login">Se reconnecter</a>.');
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    }
}
?>