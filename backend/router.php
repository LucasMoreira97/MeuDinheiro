<?php

require_once __DIR__ . '../../autoload.php'; 

use Controllers\UserSession;
use Controllers\ExpensesController;


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = substr($uri, strpos($uri, '.php') + strlen('.php'));


$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {

    case '/login':
        if ($method === 'POST') {
            $controller = new UserSession();
            $controller->login();
        } else {
           //Tratar erro, caso ocorra
        }
        break;
    
    case '/expenses':
        $data = json_decode(file_get_contents('php://input'), true);
        $response = (new ExpensesController)->controller($data);
        echo json_encode($response);
        break;

}
?>
