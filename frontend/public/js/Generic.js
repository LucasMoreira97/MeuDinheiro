class Generic {

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


    previewUserPhoto(input) {
        var file = input.files[0];
        var reader = new FileReader();
        var $preview = $('#user-photo-preview');
        var $placeholder = $('.user-photo-placeholder');

        reader.onload = function (e) {
            $preview.attr('src', e.target.result).addClass('uploaded');
            $placeholder.hide();
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }



}


var generic = new Generic;

$(document).ready(function () {
    $('#user-photo').on('change', function () {
        generic.previewUserPhoto(this);
    });
});

// $('.menu-item').on('click', function() {
//     generic.selectMenuItem();
// });