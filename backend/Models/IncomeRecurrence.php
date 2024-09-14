<?php

namespace Models;

use Config\DB;

class IncomeRecurrence extends DB
{

    public function newIncomeRecurrence($data, $user_id){

        $previouslyRegistered = $this->previouslyRegistered($data['name']);

        if (!$previouslyRegistered) {

            $current_time = time();

            $sql = 'INSERT INTO income_recurrence (name, recurrence_in_days, user_id, registration_date, modification_date) VALUES (:name, :recurrence_in_days, :user_id, :registration_date, :modification_date)';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':recurrence_in_days', $data['recurrence_in_days']);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':registration_date', $current_time);
            $stmt->bindParam(':modification_date', $current_time);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Cadastro realizado com sucesso!'];
            } else {
                return ['success' => false, 'message' => 'Algo deu errado, tente novamente!'];
            }

        } else {

            return ['success' => false, 'message' => 'Essa recorrencia já foi cadastrado anteriormente.'];
        }
    }

    public function listIncomeRecurrence($recurrence_id = null) {
        $sql = 'SELECT id, name, recurrence_in_days FROM income_recurrence WHERE removed = 0 ';
        $sql .= $recurrence_id ? ' AND id = :recurrence_id' : '';
        $sql .= ' ORDER BY id DESC';
    
        $stmt = $this->db->prepare($sql);
    
        if ($recurrence_id) {
            $stmt->bindValue(':recurrence_id', $recurrence_id);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function previouslyRegistered($name) {

        $sql = 'SELECT name FROM income_recurrence WHERE name = :name AND removed = 0 LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function editIncomeRecurrence($recurrence_id, $data){

        $sql = 'UPDATE income_recurrence SET name = :name, recurrence_in_days = :recurrence_in_days WHERE id = :recurrence_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':recurrence_in_days', $data['recurrence_in_days']);
        $stmt->bindParam(':recurrence_id', $recurrence_id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'Recorrencia editada com sucesso!'];
        }else{
            return ['success' => false, 'message' => 'Erro ao atualizar recorrencia'];
        }
    }

    public function removeIncomeRecurrence($recurrence_id){

        $sql = 'UPDATE income_recurrence SET removed = 1 WHERE id = :recurrence_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':recurrence_id', $recurrence_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'Recorrencia removido com sucesso!'];
        }else{
            return ['success' => false, 'message' => 'Error ao remover recorrencia.'];
        }

    }

}
