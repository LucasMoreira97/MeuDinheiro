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
                if($data['method_id'] > 0){
                    $response = (new PaymentMethod)->editPaymentMethod($data['method_id'], $data);
                }else{
                    $response = (new PaymentMethod)->newPaymentMethod($data, $user_id);
                }
                
               break;

            case 'list_payment_methods':
                $response = (new PaymentMethod)->listPaymentMethods();
                break;

            case 'data_payment_method':
                $payment_method = (new PaymentMethod)->listPaymentMethods($data['method_id']);
                $response = $payment_method[0];
                break;

            case 'edit_payment_method':
                $response = (new PaymentMethod)->listPaymentMethods($data['id']);
                break;

        }

        return $response;
    }

}