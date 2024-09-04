<?php

require_once __DIR__ . '../../autoload.php'; 

use Controllers\UserSession;


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = substr($uri, strpos($uri, '.php') + strlen('.php'));


$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {

    case '/login':
        if ($method === 'POST') {
            $controller = new UserSession();
            $controller->login();
        } else {
            // Exibir formulário de login ou tratar GET de outra forma
        }
        break;

}
?>
