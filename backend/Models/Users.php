<?php

namespace Models;

use Config\DB;

class Users extends DB
{

    public function createUser($data)
    {

        $user_already_exists = $this->findUserByEmail($data['email']);
        if ($user_already_exists) {
            return ['code' => '404', 'message' => 'Not Found'];
        }

        $sql = 'INSERT INTO users (name, email, username, password, profile_picture, date_of_birth, phone_number, status, last_login, email_verified, group_id, created_at, updated_at) VALUES (:name, :email, :username, :password, :profile_picture, :date_of_birth, :phone_number, :status, :last_login, :email_verified, :group_id, :created_at, :updated_at)';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':profile_picture', $data['profile_picture']);
        $stmt->bindParam(':date_of_birth', $data['date_of_birth']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':last_login', $data['last_login']);
        $stmt->bindParam(':email_verified', $data['email_verified']);
        $stmt->bindParam(':group_id', $data['group_id']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':updated_at', $data['updated_at']);
        $stmt->execute();

        return ['code' => '200', 'message' => 'ok'];
    }

    public function loginUser($email, $password)
    {

        $sql = 'SELECT id, name, username, password, status FROM users WHERE status = "active" AND email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {

                if ($user['status'] === 'active') {

                    $this->lastLogin($user['id']);
                    unset($user['password']);

                    return 'authenticated_user';
                }
            } else {
                return 'incorrect_password';
            }
        } else {
            return 'not_registered';
        }
    }

    private function lastLogin($user_id)
    {

        $last_login = time();

        $sql = 'UPDATE users SET last_login = :last_login WHERE id = :id';
        $updateStmt = $this->db->prepare($sql);
        $updateStmt->bindParam(':last_login',  $last_login);
        $updateStmt->bindParam(':id', $user_id);
        $updateStmt->execute();
    }

    private function findUserByEmail($email)
    {

        $sql = 'SELECT id FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    /*11/09/2024*/
    public function userId($email)
    {

        $sql = 'SELECT id FROM users WHERE email = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user_id = $stmt->fetchColumn();

        return $user_id;
    }

    public function dataUser($user_id)
    {

        $sql = 'SELECT name, email, username, profile_picture, date_of_birth, phone_number FROM users WHERE id = :user_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function updateUser($user_id, $data)
    {

        $response = ['success' => false, 'message' => ''];

        $sql = "UPDATE users SET name = :name, username = :username, email = :email, phone_number = :phone, date_of_birth = :birthdate WHERE id = :user_id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':birthdate', $data['birthdate']);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $response = ['success' => true, 'message' => 'Perfil de usuário atualizado com sucesso!'];
        }

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
            $file_mame = $_FILES['profile_picture']['name'];
            $file_mame_cmps = explode(".", $file_mame);
            $file_extension = strtolower(end($file_mame_cmps));

            $upload_file_dir = '../uploads/';
            if (!is_dir($upload_file_dir)) {
                mkdir($upload_file_dir, 0755, true);
            }

            $new_file_mame = md5(time() . $file_mame) . '.' . $file_extension;

            $dest_path = $upload_file_dir . $new_file_mame;

            if (move_uploaded_file($file_tmp_path, $dest_path)) {

                $file_patch = '/MagicMoney/uploads/' . $new_file_mame;

                $sql_update_pic = "UPDATE users SET profile_picture = :profile_picture WHERE id = :user_id";
                $stmt_pdate_pic = $this->db->prepare($sql_update_pic);
                $stmt_pdate_pic->bindParam(':profile_picture', $file_patch);
                $stmt_pdate_pic->bindParam(':user_id', $user_id);
                $stmt_pdate_pic->execute();

                if($stmt_pdate_pic->rowCount() > 0){
                    $response = ['success' => true, 'message' => 'Perfil de usuário atualizado com sucesso, nova foto adicionada'];
                }
            }
        }

        return $response;
    }

}