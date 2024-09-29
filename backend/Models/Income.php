<?php

namespace Models;

use Config\DB;

class Income extends DB
{

    public function newIncome($user_id, $group_id, $data)
    {
        $current_time = time();

        $sql = 'INSERT INTO income (source, value, income_type, entry_date, description, group_id, recurrence_id, provider_id, registered_by_user_id, receipt_status, saved_at, updated_at, updated_by_user_id) 
        VALUES (:source, :value, :income_type, :entry_date, :description, :group_id, :recurrence_id, :provider_id, :registered_by_user_id, :receipt_status, :saved_at, :updated_at, :updated_by_user_id)';
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':source', $data['source']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':income_type', $data['income_type']);
        $stmt->bindParam(':entry_date', $data['income_date']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->bindParam(':recurrence_id', $data['recurrence']);
        $stmt->bindParam(':provider_id', $data['responsible']);
        $stmt->bindParam(':registered_by_user_id', $user_id);
        $stmt->bindParam(':receipt_status', $data['status']);
        $stmt->bindParam(':saved_at', $current_time);
        $stmt->bindParam(':updated_at', $current_time);
        $stmt->bindParam(':updated_by_user_id', $user_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Ótimo trabalho! A sua entrada de renda foi cadastrada com sucesso!'];
        }
    }

    public function editIncome($user_id, $data, $income_id)
    {

        $current_time = time();

        $sql = 'UPDATE income 
        SET source = :source, 
            value = :value, 
            income_type = :income_type, 
            entry_date = :entry_date, 
            description = :description,
            recurrence_id = :recurrence_id, 
            provider_id = :provider_id, 
            receipt_status = :receipt_status, 
            updated_at = :updated_at, 
            updated_by_user_id = :updated_by_user_id
        WHERE id = :id';
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':source', $data['source']);
        $stmt->bindParam(':value', $data['value']);
        $stmt->bindParam(':income_type', $data['income_type']);
        $stmt->bindParam(':entry_date', $data['income_date']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':recurrence_id', $data['recurrence']);
        $stmt->bindParam(':provider_id', $data['responsible']);
        $stmt->bindParam(':receipt_status', $data['status']);
        $stmt->bindParam(':updated_at', $current_time);
        $stmt->bindParam(':updated_by_user_id', $user_id);
        $stmt->bindParam(':id', $income_id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Tudo certo! A entrada de renda foi atualizada com sucesso. Bom trabalho!'];
        }
    }

    public function removeIncome($user_id, $income_id){

        $current_time = time();

        $sql = 'UPDATE income SET removed = 1, updated_at = :updated_at, updated_by_user_id = :updated_by_user_id WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':updated_at', $current_time);
        $stmt->bindParam(':updated_by_user_id', $user_id);
        $stmt->bindParam(':id', $income_id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'A entrada de renda foi removida com sucesso!'];
        }

    }

}
