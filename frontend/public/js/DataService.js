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
                    <span class="info remove" onclick="dataservice.removePaymentMethod(${methods.id})">Remover</span>
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

    async removePaymentMethod(method_id){

        console.log(method_id);
        
        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                method_id: method_id,
                operation: 'remove_payment_method'
            })
        });

        //Tratar erros
        const data = await response.json();

        console.log(data);

        this.listPaymentMethod();

        alert('removido com sucesso');
    }

    //Payment categories
    async savePaymentCategory() {

        var category_id = $('#save-payment-category').attr('category_id');

        const $paymentCategory = $('.payment-category');
        const name = $paymentCategory.find('#name').val();

        if (name) {

            const uri = '/MagicMoney/backend/router.php/expenses';
            const response = await fetch(uri, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({
                    category_id: category_id, name: name, operation: 'save_payment_category'
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

        this.listPaymentCategory();

        $paymentCategory.find('input').val('');
        $paymentCategory.find('.add-button').show();
        $paymentCategory.find('#add-payment-category').css('display', 'none');
        $paymentCategory.find('#list-payment-category').show();
    }

    async listPaymentCategory() {

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operation: 'list_payment_category'
            })
        });

        const data = await response.json();
        var payment_category = '';
        
        data.map(category => {

            payment_category += `
                <li class="item" id='category-id-${category.id}'>
                    <span class="info">${category.name}</span>
                    <span class="info edit" onclick="dataservice.editPaymentCategory(${category.id})">Editar</span>
                    <span class="info remove" onclick="dataservice.removePaymentCategory(${category.id})">Remover</span>
                </li>
            `;
        });

        $('#list-payment-category ul').html(payment_category);

        console.log(data);
    }

    async editPaymentCategory(category_id){

        $('#add-payment-category .save-button').attr('category_id', category_id);

        const data = await this.dataPaymentCategory(category_id);

        const $paymentCategory = $('.payment-category');

        $paymentCategory.find('#name').val(data.name);
        $paymentCategory.find('#maximum-installment').val(data.maximum_installment);
        $paymentCategory.find('#payment-type').val(data.type);

        $paymentCategory.find('.add-button').hide();
        $paymentCategory.find('#add-payment-category').css('display', 'flex');
        $paymentCategory.find('#list-payment-category').hide();
    }

    async dataPaymentCategory(category_id){

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                category_id: category_id,
                operation: 'data_payment_category'
            })
        });

        const data = await response.json();
        
        return data;
    }

    async removePaymentCategory(category_id){

        console.log(category_id);
        
        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                category_id: category_id,
                operation: 'remove_payment_category'
            })
        });

        //Tratar erros
        const data = await response.json();

        console.log(data);

        this.listPaymentCategory();

        alert('removido com sucesso');
    }



}

var dataservice = new DataService;