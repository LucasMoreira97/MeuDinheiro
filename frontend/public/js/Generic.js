class Generic {

    formatCurrency(input) {
        let currency = input.value.replace(/\D/g, '');
        let numericValue = parseInt(currency);
    
        if (isNaN(numericValue)) {
            return;
        }
    
        currency = (numericValue / 100).toFixed(2);
    
        let parts = currency.split('.');
        let first_part = parts[0];
        let second_part = parts[1];
    
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

    togglePopup(popup_id) {
        const popup = $(`#${popup_id}`);
        popup.toggleClass('active');

        $(window).on('click', function (event) {
            if ($(event.target).is(`#${popup_id}`)) {
                popup.removeClass('active');
            }
        });

        $('.close-popup').on('click', function () {
            popup.removeClass('active');
        });
    }

    popupMessage(popup_id, message, icon) {
        let $popup = $(`#${popup_id}`);
        $popup.find('.popup-message').html(message);
        $popup.find('.popup-icon').html(icon);
    }

    //Animação do cadeado do update password
    toggleLock() {
        const $lock = $('#lock');
        setTimeout(() => {
            $lock.removeClass('open').addClass('closed');
            $('.lock path').attr('fill', '#0876FE');
            $('.lock-shackle path').attr('fill', '#0876FE');
        }, 500);
    }

    closePopup() {
        $('#popup').removeClass('active');
    }

    inputsToDeleteAccount() {
        const email_filled = $('#confirm-email').val().trim() !== "";
        const password_filled = $('#confirm-password').val().trim() !== "";

        if (email_filled && password_filled) {
            $('#button-delete-account').removeClass('disabled-button').addClass('delete-button').prop('disabled', false);
        } else {
            $('#button-delete-account').removeClass('delete-button').addClass('disabled-button').prop('disabled', true);
        }
    }



    inputsToSendFeedback() {
        const type_feedback = $('#type-feedback').val();
        const message_feedback = $('#message-feedback').val();

        if (type_feedback && message_feedback) {
            $('#button-send-feedback').removeClass('disabled-button').addClass('save-button').prop('disabled', false);
        } else {
            $('#button-send-feedback').removeClass('save-button').addClass('disabled-button').prop('disabled', true);
        }
    }


    async showMessage(text, success) {
        const message_div = $('.operation-message');

        if(!success){
            message_div.css('background-color', '#F93C3A');
        }

        message_div.text(text);
        message_div.addClass('show');
        
        setTimeout(() => {
          message_div.removeClass('show');
          
          setTimeout(() => {
            message_div.text('');
          }, 1000); 
        }, 5000);
      }
    
}


var generic = new Generic;

$(document).ready(function () {
    $('#user-photo').on('change', function () {
        generic.previewUserPhoto(this);
    });

    $(window).on('click', function (event) {
        if ($(event.target).is('#popup')) {
            generic.closePopup();
        }
    });

});
