<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

$loader = new App\Bracket\Lib\Psr4AutoloaderClass();
$loader->addNamespace('App\Bracket', __DIR__ . '/../src');
$loader->register();

$controller = $_GET['controller'] ?? "produit";
$action = $_GET['action'] ?? 'home';

$controllerClassName = 'App\Bracket\Controller\\'.'Controller'.ucfirst($controller);
if (class_exists($controllerClassName)) {
    $listeActions = get_class_methods($controllerClassName);
    if (!in_array($action, $listeActions)) {
        $controllerClassName::error($action);
    } else {
        $controllerClassName::$action();
    }
} else {
    \App\Bracket\Controller\GenericController::error("", "Ce que vous cherchez n'existe pas...");
}