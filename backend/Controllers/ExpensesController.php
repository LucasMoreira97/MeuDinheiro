<?php

namespace Controllers;

session_start();

use Models\PaymentMethod;


class ExpensesController{

    public function controller($data){

        $operation = $data['operation'];
        $user_id = $_SESSION['user_id'];

        switch($operation){

            case 'save_payment_method':
                $response = (new PaymentMethod)->newPaymentMethod($data, $user_id);
               break;

            case 'list_payment_methods':
                $response = (new PaymentMethod)->listPaymentMethods();
                break;

        }

        return $response;
    }

}