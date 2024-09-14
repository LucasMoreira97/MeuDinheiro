<?php

namespace Models;

use Config\DB;

class UserGroups extends DB
{

    public function createUserGroup($user_id, $identifier)
    {

        $current_time = time();

        $sql = 'INSERT INTO user_groups (identifier, id_user_created, registration_date) VALUES (:identifier, :id_user_created, :registration_date)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->bindParam(':id_user_created', $user_id);
        $stmt->bindParam(':registration_date', $current_time);
        $stmt->execute();

        $group_id = $this->db->lastInsertId();

        return $stmt->rowCount() > 0 ? $group_id : 0;
    }

    public function getIdByUserGroup($user_id){

        $sql = 'SELECT id FROM user_groups WHERE id_user_created = :user_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $group_id = $stmt->fetchColumn();

        return $group_id;
    }

    public function getIdByUserGroupUsers($user_id){

        $sql = 'SELECT user_group_id FROM user_groups_users WHERE user_id = :user_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $group_id = $stmt->fetchColumn();

        return $group_id;
    }


    public function userAlreadyHasAGroup($user_id){

        $sql = 'SELECT id FROM user_groups WHERE id_user_created = :user_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function userIsAlreadyInAGroup($user_id){

        $sql = 'SELECT user_group_id FROM user_groups_users WHERE user_id = :user_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function addUserToUserGroup($group_id, $user_id, $request, $user_type){

        $current_time = time();

        $sql = 'INSERT INTO user_groups_users (user_group_id, user_id, request, user_type, registration_date) VALUES (:user_group_id, :user_id, :request, :user_type, :registration_date)';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_group_id', $group_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':request', $request);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':registration_date', $current_time);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? 'success' : 'error';
    }

    public function removeUserGroup($group_id){

        $sql = 'DELETE FROM user_groups WHERE id = :user_group_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_group_id', $group_id);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? 'success' : 'error';
    }

    public function removeUserFromUserGroup($user_id){

        $sql = 'DELETE FROM user_groups_users WHERE user_id = :user_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? 'success' : 'error';
    }

    public function listGroupUsers($group_id, $user_id = null){

        $sql = 'SELECT user_id, request, user_type FROM user_groups_users WHERE user_group_id = :group_id';
        $sql .= !empty($user_id) ? ' AND user_id = :user_id' : '';
        $stmt = $this->db->prepare($sql);

        if(!empty($user_id)){
            $stmt->bindParam(':user_id', $user_id);
        }

        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}