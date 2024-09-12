class DataService {

    async savePaymentMethod() {

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
                    name: name, installment: installment, type: type, operation: 'save_payment_method'
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
                    <span class="info edit">Editar</span>
                    <span class="info remove">Remover</span>
                </li>
            `;
        });

        $('#list-payment-methods ul').html(payment_methods);

        console.log(data);
    }
}

var dataservice = new DataService;