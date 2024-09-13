class Home {

    async loadPage(page) {

        switch (page) {

            case 'income':
            case 'expenses':
            case 'investments':
            case 'settings':
                $('#home-page').load('../src/views/' + page + '.html');
                break;

            case 'settings-profile':
                $('#home-page').load('../src/views/settings/profile.html');
                break;

            case 'settings-expenses':
                $('#home-page').load('../src/views/settings/expenses.html');
                break;

            case 'payment-method':
                var dataservice = new DataService;
                dataservice.listPaymentMethod();
                $('#home-page').load('../src/views/expense-settings/payment-method.html');
                break;

            case 'payment-category':
                $('#home-page').load('../src/views/expense-settings/payment-category.html');
                break;

            case 'payment-type':
                $('#home-page').load('../src/views/expense-settings/payment-type.html');
                break;

            case 'settings-income':
                $('#home-page').load('../src/views/settings/income.html');
                break;

            case 'income-recurrence':
                $('#home-page').load('../src/views/income-settings/income-recurrence.html');
                break;

        }

    }
}

var home = new Home;