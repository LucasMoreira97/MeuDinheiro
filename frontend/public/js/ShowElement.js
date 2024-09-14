class ShowElement {


    //Used for Payment type, method, category.
    showAdd(origin) {
        $('#add-' + origin + '#name').val();

        if (origin == 'payment-method') {
            $('#add-' + origin + ' #maximum-installment').val();
        }

        if(origin == 'income-recurrence'){
            $('#add-' + origin + ' #recurrence-in-days').val();
        }

        $('.add-button').hide();
        $('#add-' + origin).css('display', 'flex');
        $('#list-' + origin).hide();
    }

    hideAdd(origin) {
        $('#add-' + origin + ' #name').val();

        if (origin == 'payment-method') {
            $('#add-' + origin + ' #maximum-installment').val();
        }

        if(origin == 'income-recurrence'){
            $('#add-' + origin + ' #recurrence-in-days').val();
        }

        $('.add-button').show();
        $('#add-' + origin).css('display', 'none');
        $('#list-' + origin).show();
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