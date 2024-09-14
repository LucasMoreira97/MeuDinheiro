<?php

require_once __DIR__ . '../../autoload.php';

use Controllers\UserSession;
use Controllers\ExpensesController;
use Controllers\GenericController;

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

    case '/income':
    case '/expenses':
        $data = json_decode(file_get_contents('php://input'), true);
        $response = (new ExpensesController)->controller($data);
        echo json_encode($response);
        break;

    case '/profile/data':
        $data = json_decode(file_get_contents('php://input'), true);
        $data = !empty($data) ? $data : ['operation' => 'user_profile_data'];

        $response = (new GenericController)->controller($data);
        echo json_encode($response);
        break;

    case '/profile':

        if ($_POST['operation'] == 'save_user_profile_data') {
            $data = ['operation' => 'save_user_profile_data'];
            $response = (new GenericController)->controller($data);
            echo json_encode($response);
        }
        break;

    case '/general':
        $data = json_decode(file_get_contents('php://input'), true);
        $response = (new GenericController)->controller($data);
        echo json_encode($response);
        break;
}
