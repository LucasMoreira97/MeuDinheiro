class ShowElement {


    addPaymentMethod() {
        $('#add-payment-method #name').val();
        $('#add-payment-method #maximum_installment').val();
        $('.add-button').hide();
        $('#add-payment-method').css('display', 'flex');
        $('#list-payment-methods').hide();
    }

    savePaymentMethod() {
        $('#add-payment-method #name').val();
        $('#add-payment-method #maximum_installment').val();
        $('.add-button').show();
        $('#add-payment-method').css('display', 'none');
        $('#list-payment-methods').show();
    }


    test() {
        $('.add-button').hide();
        $('#add-payment-method').css('display', 'flex');
        $('#list-payment-methods').hide();
        $('#name').val('Cartão de crédito itaú');
        $('#maximum_installment').val(8);

    }

    test2() {
        $('.add-button').hide();
        $('#add-payment-category').css('display', 'flex');
        $('#list-payment-category').hide();
        $('#name').val('Transporte');
    }


    addCategory() {
        $('#add-payment-category #name').val();
        $('.add-button').hide();
        $('#add-payment-category').css('display', 'flex');
        $('#list-payment-category').hide();
    }

    saveCategory() {
        $('#add-payment-category #name').val();

        $('.add-button').show();
        $('#add-payment-category').css('display', 'none');
        $('#list-payment-category').show();
    }


    addRecurrence() {
        $('.add-button').hide();
        $('#add-income-recurrence').css('display', 'flex');
        $('#list-income-recurrence').hide();
    }

    saveRecurrence() {
        $('.add-button').show();
        $('#add-income-recurrence').css('display', 'none');
        $('#list-income-recurrence').show();
    }




}

var showelement = new ShowElement;