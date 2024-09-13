class DataService {

    async savePaymentMethod() {

        var method_id = $('#save-payment-method').attr('method_id');

        const $paymentMethod = $('.payment-method');

        const name = $paymentMethod.find('#name').val();
        const installment = $paymentMethod.find('#maximum-installment').val();
        const type = $paymentMethod.find('#payment-type').val();

        if (name && installment && type) {

            const uri = '/MagicMoney/backend/router.php/expenses';
            const response = await fetch(uri, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({
                    method_id: method_id, name: name, installment: installment, type: type, operation: 'save_payment_method'
                })
            });
        
            const data = await response.json();
            console.log(data);
        
            // Preciso configurar as mensagens de erro.
            if(data.success == true){
                alert('salvo com sucesso')
            }else{
                alert('erro ao salvar');
            }
        }

        this.listPaymentMethod();

        $paymentMethod.find('input').val('');
        $paymentMethod.find('.add-button').show();
        $paymentMethod.find('#add-payment-method').css('display', 'none');
        $paymentMethod.find('#list-payment-methods').show();

    }

    async listPaymentMethod() {

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operation: 'list_payment_methods'
            })
        });

        const data = await response.json();
        var payment_methods = '';
        
        data.map(methods => {

            if(methods.type == 'credit'){
                var payment_type = 'Crédito'
            }else{
                var payment_type = 'Imediato';
            }

            payment_methods += `
                <li class="item" id='method-id-${methods.id}'>
                    <span class="info">${methods.name}</span>
                    <span class="info">${payment_type}</span>
                    <span class="info">Parcelamento máximo ${methods.maximum_installment}x</span>
                    <span class="info edit" onclick="dataservice.editPaymentMethod(${methods.id})">Editar</span>
                    <span class="info remove">Remover</span>
                </li>
            `;
        });

        $('#list-payment-methods ul').html(payment_methods);

        console.log(data);
    }

    async editPaymentMethod(method_id){

        $('#add-payment-method .save-button').attr('method_id', method_id);

        const data = await this.dataPaymentMethod(method_id);

        const $paymentMethod = $('.payment-method');

        $paymentMethod.find('#name').val(data.name);
        $paymentMethod.find('#maximum-installment').val(data.maximum_installment);
        $paymentMethod.find('#payment-type').val(data.type);

        $paymentMethod.find('.add-button').hide();
        $paymentMethod.find('#add-payment-method').css('display', 'flex');
        $paymentMethod.find('#list-payment-methods').hide();

    }

    async dataPaymentMethod(method_id){

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                method_id: method_id,
                operation: 'data_payment_method'
            })
        });

        const data = await response.json();
        
        return data;
    }
}

var dataservice = new DataService;