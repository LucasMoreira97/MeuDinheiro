<?php

namespace Controllers;

date_default_timezone_set('America/Sao_Paulo');

session_start();

use Models\Users;

class GenericController{

    public function controller($data)
    {

        $operation = $data['operation'];
        $user_id = $_SESSION['user_id'];

        switch ($operation) {

            case 'user_profile_data':
                $response = (new Users)->dataUser($user_id);
                $response['date_of_birth'] = date('Y-m-d', $response['date_of_birth']);
                break;

            case 'save_user_profile_data':
                $data = [];
                $data['name'] = $_POST['name'];
                $data['username'] = $_POST['username'];
                $data['email'] = $_POST['email'];
                $data['phone'] = $_POST['phone'];
                $data['birthdate'] = strtotime($_POST['birthdate']);

                $response = (new Users)->updateUser($user_id, $data, $_FILES);
                break;
        }

        return $response;
    }
}
