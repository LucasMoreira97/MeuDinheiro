class Generic {

    // selectMenuItem(){
    //     $('.menu-item').removeClass('active');
    //     $(this).addClass('active');
    // }




    formatCurrency(input) {

        let currency = input.value.replace(/\D/g, '');
        currency = (parseInt(currency) / 100).toFixed(2) + '';

        let first_part = currency.split('.')[0];
        let second_part = currency.split('.')[1];

        first_part = first_part.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        input.value = first_part + ',' + second_part;
    }

    setTodayDate(id) {

        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Mês de 0 a 11
        const day = String(today.getDate()).padStart(2, '0');

        const formatted_date = `${year}-${month}-${day}`;

        $('#' + id).val(formatted_date);
    }


}


var generic = new Generic;

// $('.menu-item').on('click', function() {
//     generic.selectMenuItem();
// });