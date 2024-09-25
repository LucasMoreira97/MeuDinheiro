<?php

namespace Controllers;

date_default_timezone_set('America/Sao_Paulo');

session_start();

use Models\Users;
use Models\UserGroups;

class GenericController
{

    public function controller($data)
    {

        $operation = $data['operation'];
        $user_id = $_SESSION['user_id'];
        $user_email = $_SESSION['email'];

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

            case 'save-managment-group':

                $response = ['success' => false, 'message' => 'Falha na solicitação'];

                $Users = new Users;
                $UserGroups = new UserGroups;

                $user_has_group = $UserGroups->userAlreadyHasAGroup($user_id);
                $user_in_group = $UserGroups->userIsAlreadyInAGroup($user_id);

                if (!$user_has_group && !$user_in_group) {

                    $group_id = $UserGroups->createUserGroup($user_id, $user_email);
                    $UserGroups->addUserToUserGroup($group_id, $user_id, 'accepted', 'admin');
                } elseif ($user_in_group) {

                    $group_id = $UserGroups->getIdByUserGroupUsers($user_id);
                }

                $user_id_found = $Users->userId($data['email']);

                if (!empty($user_id_found)) {

                    $group_id_user = $UserGroups->getIdByUserGroupUsers($user_id_found);

                    if ($group_id_user == $group_id) {

                        $response = ['success' => false, 'message' => 'Este usuário já foi adicionado e pertence a este grupo.'];
                    } elseif (!empty($group_id_user)) {

                        $response = ['success' => false, 'message' => 'Este usuário já pertence a outro grupo. Solicite que ele saia do grupo anterior e tente adicioná-lo a este.'];
                    } else {

                        $addUser = $UserGroups->addUserToUserGroup($group_id, $user_id_found, 'pending', 'member');
                        $response = $addUser == 'success' ? ['success' => true, 'message' => 'O usuário foi adicionado ao grupo.'] : $response;
                    }
                } else {

                    $response = ['success' => false, 'message' => 'Este usuário não foi localizado. Por favor, solicite que ele se cadastre e faça esta solicitação novamente.'];
                }

                break;


            case 'list_user_group_users':

                $Users = new Users;
                $UserGroups = new UserGroups;

                $group_id = $UserGroups->getIdByUserGroupUsers($user_id);
                $group_users = $UserGroups->listGroupUsers($group_id);

                foreach($group_users as $key => $group_user){

                    $user_data = $Users->dataUser($group_user['user_id']);

                    if($group_user['user_id'] == $user_id){
                        $group_users[$key]['name'] = $user_data['name'].'(Você)';
                    }else{
                        $group_users[$key]['name'] = $user_data['name'];
                    }

                    $group_users[$key]['email'] = $user_data['email'];
                }

                $response = $group_users;
                break;

            
            case 'remove_group_user':

                $Users = new Users;
                $UserGroups = new UserGroups;

                $group_id = $UserGroups->getIdByUserGroupUsers($data['user_id']);
                $user_details = $UserGroups->listGroupUsers($group_id, $data['user_id']);

                if($user_details[0]['user_type'] == 'admin'){
                
                    $response = ['success' => false, 'message' => 'Não é possível remover o administrador do grupo.'];
                
                }else{

                    $UserGroups->removeUserFromUserGroup($data['user_id']);
                    $response = ['success' => true, 'message' => 'O membro foi removido do grupo com sucesso.'];

                }

                break;

            case 'update_password':

                $current_password = $data['current_password'];
                $new_password = $data['new_password'];
                $confirm_password = $data['confirm_password'];

                if($new_password != $confirm_password){
                    $response = ['success' => false, 'message' => 'As senhas inseridas não coincidem. Por favor, verifique e tente novamente.'];
                    return $response;
                }

                $response = (new Users)->updatePassword($user_email, $current_password, $new_password);
                break;
        }

        return $response;
    }
}
