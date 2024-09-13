<?php

namespace Models;

use Config\DB;

class PaymentType extends DB
{

    public function newPaymentType($data, $user_id)
    {

        $previouslyRegistered = $this->previouslyRegistered($data['name']);

        if (!$previouslyRegistered) {

            $current_time = time();

            $sql = 'INSERT INTO outflows_types (name, user_id, registration_date, modification_date) VALUES (:name, :user_id, :registration_date, :modification_date)';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $data['name']);
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

            return ['success' => false, 'message' => 'Essa tipo de pagamento já foi cadastrado anteriormente.'];
        }
    }

    public function listPaymentType($type_id = null) {
        $sql = 'SELECT id, name FROM outflows_types WHERE removed = 0 ';
        $sql .= $type_id ? ' AND id = :type_id' : '';
        $sql .= ' ORDER BY id DESC';
    
        $stmt = $this->db->prepare($sql);
    
        if ($type_id) {
            $stmt->bindValue(':type_id', $type_id);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function previouslyRegistered($name) {

        $sql = 'SELECT name FROM outflows_types WHERE name = :name LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function editPaymentType($type_id, $data){

        $sql = 'UPDATE outflows_types SET name = :name WHERE id = :type_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':type_id', $type_id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'tipo de pagamento editado com sucesso!'];
        }else{
            return ['success' => false, 'message' => 'Erro ao atualizar tipo de pagamento'];
        }
    }

    public function removePaymentType($type_id){

        $sql = 'UPDATE outflows_types SET removed = 1 WHERE id = :type_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':type_id', $type_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'tipo de pagamento removido com sucesso!'];
        }else{

            return ['success' => false, 'message' => 'Error ao remover tipo de pagamento.'];
        }

    }

}
