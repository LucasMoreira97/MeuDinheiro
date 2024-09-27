<?php

namespace Models;

use Config\DB;

class Feedback extends DB
{

    public function newFeedback($email, $type, $message)
    {

        $current_time = time();

        $sql = 'INSERT INTO support (email, type, message, date) VALUES (:email, :type, :message, :date)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':date', $current_time);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Obrigado! Seu feedback foi enviado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Ocorreu um erro. Por favor, faça logout e tente novamente.'];
        }
    }
    
}
