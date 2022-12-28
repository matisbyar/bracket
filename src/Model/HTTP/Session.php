<?php
namespace App\Bracket\Model\HTTP;

use App\Bracket\Config\Conf;
use App\Bracket\Lib\MessageFlash;
use Exception;

class Session {
    private static ?Session $instance = null;

    /**
    * @throws Exception
    */
    private function __construct() {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session {
        if (is_null(static::$instance)) static::$instance = new Session();
        self::$instance->verifierDerniereActivite();
        return static::$instance;
    }

    public function contient($name): bool {
        return isset($_SESSION[$name]);
    }

    public function enregistrer(string $name, mixed $value): void {
        session_start();
        $_SESSION[$name] = $value;
    }

    public function lire(string $name): mixed {
        return $_SESSION[$name];
    }

    public function supprimer($name): void {
        unset($_SESSION[$name]);
    }

    public function detruire() : void {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
        // Il faudra reconstruire la session au prochain appel de getInstance()
        $instance = null;
    }

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