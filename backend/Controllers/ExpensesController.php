<?php

namespace Controllers;

session_start();

use Models\PaymentMethod;
use Models\PaymentCategory;
use Models\PaymentType;
use Models\IncomeRecurrence;

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

            //Payment types
            case 'save_payment_type':
                if ($data['type_id'] > 0) {
                    $response = (new PaymentType)->editPaymentType($data['type_id'], $data);
                } else {
                    $response = (new PaymentType)->newPaymentType($data, $user_id);
                }

                break;

            case 'list_payment_type':
                $response = (new PaymentType)->listPaymentType();
                break;

            case 'data_payment_type':
                $payment_type = (new PaymentType)->listPaymentType($data['type_id']);
                $response = $payment_type[0];
                break;

            case 'remove_payment_type':
                $response = (new PaymentType)->removePaymentType($data['type_id']);
                break;

            //Income recurrence
            case 'save-income-recurrence':
                if ($data['recurrence_id'] > 0) {
                    $response = (new IncomeRecurrence)->editIncomeRecurrence($data['recurrence_id'], $data);
                } else {
                    $response = (new IncomeRecurrence)->newIncomeRecurrence($data, $user_id);
                }
                break;

            case 'list_income_recurrence':
                $response = (new IncomeRecurrence)->listIncomeRecurrence();
                break;

            case 'specific_income_data':
                $income_recurrence = (new IncomeRecurrence)->listIncomeRecurrence($data['recurrence_id']);
                $response = $income_recurrence[0];
                break;

            case 'remove_income_recurrence':
                $response = (new IncomeRecurrence)->removeIncomeRecurrence($data['recurrence_id']);
                break;
        }

        return $response;
    }
}
