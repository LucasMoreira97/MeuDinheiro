<?php

namespace Models;

use Config\DB;

class PaymentCategory extends DB
{

    public function newPaymentCategory($data, $user_id)
    {

        $previouslyRegistered = $this->previouslyRegistered($data['name']);

        if (!$previouslyRegistered) {

            $current_time = time();

            $sql = 'INSERT INTO outflows_categories (name, user_id, registration_date, modification_date) VALUES (:name, :user_id, :registration_date, :modification_date)';

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

            return ['success' => false, 'message' => 'Essa categoria de pagamento já foi cadastrado anteriormente.'];
        }
    }

    public function listPaymentCategory($category_id = null) {
        $sql = 'SELECT id, name FROM outflows_categories WHERE removed = 0 ';
        $sql .= $category_id ? ' AND id = :category_id' : '';
        $sql .= ' ORDER BY id DESC';
    
        $stmt = $this->db->prepare($sql);
    
        if ($category_id) {
            $stmt->bindValue(':category_id', $category_id);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function previouslyRegistered($name) {

        $sql = 'SELECT name FROM outflows_categories WHERE name = :name AND removed = 0 LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    }

    public function editPaymentCategory($category_id, $data){

        $sql = 'UPDATE outflows_categories SET name = :name WHERE id = :category_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'Categoria de pagamento editado com sucesso!'];
        }else{
            return ['success' => false, 'message' => 'Erro ao atualizar categoria de pagamento'];
        }
    }

    public function removePaymentCategory($category_id){

        $sql = 'UPDATE outflows_categories SET removed = 1 WHERE id = :category_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return ['success' => true, 'message' => 'Categoria de pagamento removido com sucesso!'];
        }else{

            return ['success' => false, 'message' => 'Error ao remover categoria de pagamento.'];
        }

    }

}
