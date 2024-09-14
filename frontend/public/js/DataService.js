class DataService {

    //AJUSTAR DESPESAS
    async savePaymentMethod() {

        var method_id = $('#save-payment-method').attr('method_id');

        const $paymentMethod = $('.payment-method');

        const name = $paymentMethod.find('#name').val();
        const installment = $paymentMethod.find('#maximum-installment').val();
        const type = $paymentMethod.find('#payment-type').val();

        $paymentMethod.find('input').val('');

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
            if (data.success == true) {
                alert('salvo com sucesso')
            } else {
                alert('erro ao salvar');
            }
        }

        this.listPaymentMethod();
        showelement.hideAdd('payment-method');
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

            if (methods.type == 'credit') {
                var payment_type = 'Crédito'
            } else {
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

        $('#list-payment-method ul').html(payment_methods);
    }

    async editPaymentMethod(method_id) {

        $('#add-payment-method .save-button').attr('method_id', method_id);

        const data = await this.dataPaymentMethod(method_id);

        const $paymentMethod = $('.payment-method');

        $paymentMethod.find('#name').val(data.name);
        $paymentMethod.find('#maximum-installment').val(data.maximum_installment);
        $paymentMethod.find('#payment-type').val(data.type);

        showelement.showAdd('payment-method');
    }

    async dataPaymentMethod(method_id) {

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

    async removePaymentMethod(method_id) {

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
        $paymentCategory.find('input').val('');

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
            if (data.success == true) {
                alert('salvo com sucesso')
            } else {
                alert('erro ao salvar');
            }
        }

        this.listPaymentCategory();
        showelement.hideAdd('payment-category');
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

    async editPaymentCategory(category_id) {

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

    async dataPaymentCategory(category_id) {

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

    async removePaymentCategory(category_id) {

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

    //Payment types
    async savePaymentType() {

        var type_id = $('#save-payment-type').attr('type_id');

        const $paymentType = $('.payment-type');
        const name = $paymentType.find('#name').val();
        $paymentType.find('input').val('');

        if (name) {

            const uri = '/MagicMoney/backend/router.php/expenses';
            const response = await fetch(uri, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({
                    type_id: type_id, name: name, operation: 'save_payment_type'
                })
            });

            const data = await response.json();
            console.log(data);

            // Preciso configurar as mensagens de erro.
            if (data.success == true) {
                alert('salvo com sucesso')
            } else {
                alert('erro ao salvar');
            }
        }

        this.listPaymentType();
        showelement.hideAdd('payment-type');
    }

    async listPaymentType() {

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operation: 'list_payment_type'
            })
        });

        const data = await response.json();
        var payment_type = '';

        data.map(type => {

            payment_type += `
                <li class="item" id='type-id-${type.id}'>
                    <span class="info">${type.name}</span>
                    <span class="info edit" onclick="dataservice.editPaymentType(${type.id})">Editar</span>
                    <span class="info remove" onclick="dataservice.removePaymentType(${type.id})">Remover</span>
                </li>
            `;
        });

        $('#list-payment-type ul').html(payment_type);

        console.log(data);
    }

    async editPaymentType(type_id) {

        $('#add-payment-type .save-button').attr('type_id', type_id);

        const data = await this.dataPaymentType(type_id);

        const $paymentType = $('.payment-type');

        $paymentType.find('#name').val(data.name);
        $paymentType.find('#maximum-installment').val(data.maximum_installment);
        $paymentType.find('#payment-type').val(data.type);

        $paymentType.find('.add-button').hide();
        $paymentType.find('#add-payment-type').css('display', 'flex');
        $paymentType.find('#list-payment-type').hide();
    }

    async dataPaymentType(type_id) {

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                type_id: type_id,
                operation: 'data_payment_type'
            })
        });

        const data = await response.json();

        return data;
    }

    async removePaymentType(type_id) {

        console.log(type_id);

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                type_id: type_id,
                operation: 'remove_payment_type'
            })
        });

        //Tratar erros
        const data = await response.json();

        console.log(data);

        this.listPaymentType();

        alert('removido com sucesso');
    }

    // AJUSTAR RECEITAS
    async saveIncomeRecurrence() {

        var recurrence_id = $('#save-income-recurrence').attr('recurrence_id');

        const $incomeRecurrence = $('.income-recurrence');

        const name = $incomeRecurrence.find('#name').val();
        const recurrence_in_days = $incomeRecurrence.find('#recurrence-in-days').val();

        console.log('Name: ' + name, 'recurrence-in-days: ' + recurrence_in_days);

        $incomeRecurrence.find('input').val('');

        if (name) {

            const uri = '/MagicMoney/backend/router.php/income';
            const response = await fetch(uri, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({
                    recurrence_id: recurrence_id, recurrence_in_days: recurrence_in_days, name: name, operation: 'save-income-recurrence'
                })
            });

            const data = await response.json();
            console.log(data);

            // Preciso configurar as mensagens de erro.
            if (data.success == true) {
                alert('salvo com sucesso')
            } else {
                alert('erro ao salvar');
            }
        }

        this.listIncomeRecurrence();
        showelement.hideAdd('income-recurrence');
    }

    async listIncomeRecurrence() {

        const uri = '/MagicMoney/backend/router.php/income';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operation: 'list_income_recurrence'
            })
        });

        const data = await response.json();
        var income_recurrence = '';

        data.map(recurrence => {

            income_recurrence += `
                <li class="item" id='recurrence-id-${recurrence.id}'>
                    <span class="info">${recurrence.name}</span>
                    <span class="info">${recurrence.recurrence_in_days} dias</span>
                    <span class="info edit" onclick="dataservice.editIncomeRecurrence(${recurrence.id})">Editar</span>
                    <span class="info remove" onclick="dataservice.removeIncomeRecurrence(${recurrence.id})">Remover</span>
                </li>
            `;
        });

        $('#list-income-recurrence ul').html(income_recurrence);

        console.log(data);
    }

    async editIncomeRecurrence(recurrence_id) {

        $('#add-income-recurrence .save-button').attr('recurrence_id', recurrence_id);

        const data = await this.dataIncomeRecurrence(recurrence_id);

        const $incomeRecurrence = $('.income-recurrence');

        $incomeRecurrence.find('#name').val(data.name);
        $incomeRecurrence.find('#recurrence-in-days').val(data.recurrence_in_days);

        $incomeRecurrence.find('.add-button').hide();
        $incomeRecurrence.find('#add-income-recurrence').css('display', 'flex');
        $incomeRecurrence.find('#list-income-recurrence').hide();
    }

    async dataIncomeRecurrence(recurrence_id) {

        const uri = '/MagicMoney/backend/router.php/expenses';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                recurrence_id: recurrence_id,
                operation: 'data_income_recurrence'
            })
        });

        const data = await response.json();

        return data;
    }

    async removeIncomeRecurrence(recurrence_id) {

        const uri = '/MagicMoney/backend/router.php/income';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                recurrence_id: recurrence_id,
                operation: 'remove_income_recurrence'
            })
        });

        //Tratar erros
        const data = await response.json();

        console.log(data);
        this.listIncomeRecurrence();

        alert('removido com sucesso');
    }

}

var dataservice = new DataService;