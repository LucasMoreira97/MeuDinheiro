<?php

namespace Controllers;

session_start();

use Models\PaymentMethod;
use Models\PaymentCategory;

class ExpensesController
{

    public function controller($data)
    {

        $operation = $data['operation'];
        $user_id = $_SESSION['user_id'];

        switch ($operation) {

            //Payment methods
            case 'save_payment_method':
                if ($data['method_id'] > 0) {
                    $response = (new PaymentMethod)->editPaymentMethod($data['method_id'], $data);
                } else {
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

            case 'remove_payment_method':
                $response = (new PaymentMethod)->removePaymentMethod($data['method_id']);
                break;
            
                //Payment categories
            case 'save_payment_category':
                if ($data['category_id'] > 0) {
                    $response = (new PaymentCategory)->editPaymentCategory($data['category_id'], $data);
                } else {
                    $response = (new PaymentCategory)->newPaymentCategory($data, $user_id);
                }

                break;

            case 'list_payment_category':
                $response = (new PaymentCategory)->listPaymentCategory();
                break;

            case 'data_payment_category':
                $payment_category = (new PaymentCategory)->listPaymentCategory($data['category_id']);
                $response = $payment_category[0];
                break;

            case 'remove_payment_category':
                $response = (new PaymentCategory)->removePaymentCategory($data['category_id']);
                break;
        }

        return $response;
    }
}
