<?php

namespace Models;

use Config\DB;

class PaymentMethod extends DB
{

    public function newPaymentMethod($data, $user_id)
    {

        $previouslyRegistered = $this->previouslyRegistered($data['name']);

        if (!$previouslyRegistered) {

            $current_time = time();

            $sql = 'INSERT INTO payment_methods (name, maximum_installment, user_id, type, registration_date, modification_date) VALUES (:name, :maximum_installment, :user_id, :type, :registration_date, :modification_date)';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':maximum_installment', $data['installment']);
            $stmt->bindParam(':type', $data['type']);
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

            return ['success' => false, 'message' => 'Esse método de pagamento já foi cadastrado anteriormente.'];
        }
    }

    public function listPaymentMethods($method_id = null) {
        $sql = 'SELECT id, name, maximum_installment, type FROM payment_methods WHERE removed = 0 ';
        $sql .= $method_id ? ' AND id = :method_id' : '';
        $sql .= ' ORDER BY id DESC';
    
        $stmt = $this->db->prepare($sql);
    
        if ($method_id) {
            $stmt->bindValue(':method_id', $method_id);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function previouslyRegistered($name) {

        $sql = 'SELECT name FROM payment_methods WHERE name = :name LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function editPaymentMethod($method_id, $data){

        $sql = 'UPDATE payment_methods SET name = :name, maximum_installment = :installment, type = :type WHERE id = :method_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':installment', $data['installment']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':method_id', $method_id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'Método de pagamento editado com sucesso!'];
        }else{
            return ['success' => false, 'message' => 'Erro ao atualizar método de pagamento'];
        }
    }

    public function removePaymentMethod($method_id){

        $sql = 'UPDATE payment_methods SET removed = 1 WHERE id = :method_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':method_id', $method_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'Método de pagamento removido com sucesso!'];
        }else{

            return ['success' => false, 'message' => 'Error ao remover Método de pagamento.'];
        }

    }

}
