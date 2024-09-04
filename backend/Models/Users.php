<?php

namespace Models;

use Config\DB;

class Users extends DB{

    public function createUser($data){

        $userAlreadyExists = $this->findUserByEmail($data['email']);
        if($userAlreadyExists){
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

    public function loginUser($email, $password){

        $sql = 'SELECT id, name, username, password, status FROM users WHERE email = :email LIMIT 1';
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

    private function lastLogin($userId){

        $lastLogin = time();

        $sql = 'UPDATE users SET last_login = :last_login WHERE id = :id';
        $updateStmt = $this->db->prepare($sql);
        $updateStmt->bindParam(':last_login',  $lastLogin);
        $updateStmt->bindParam(':id', $userId);
        $updateStmt->execute();
    }

    private function findUserByEmail($email){

        $sql = 'SELECT id FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

}
