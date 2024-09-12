<?php

namespace Controllers;

use Models\Users;

class UserSession
{

    public function login()
    {
        session_start();

        $data = json_decode(file_get_contents('php://input'));
        $response = [];

        $email = isset($data->email) ? $data->email : null;
        $password = isset($data->password) ? $data->password : null;

        if (!$email) {
            echo json_encode(['success' => false, 'message' => 'Email não fornecido']);
        }

        if (!$password) {
            echo json_encode(['success' => false, 'message' => 'Senha não fornecida']);
        }

        $users = new Users;
        $auth_status = $users->loginUser($email, $password);
        $user_id = $users->userId($email);


        switch ($auth_status) {

            case 'authenticated_user':
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;

                $response = ['success' => true];
                break;

            case 'incorrect_password':
                $response = ['success' => false, 'message' => 'Senha incorreta'];
                break;

            case 'not_registered':
                $response = ['success' => false, 'message' => 'Endereço de email não cadastrado'];
                break;
        }

        echo json_encode($response);
        //return $response;
    }
}
