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

            //Expenses
            case 'settings-expenses':
                $('#home-page').load('../src/views/settings/expenses.html');
                break;

            //Expenses
            case 'payment-method':
                var dataservice = new DataService;
                dataservice.listPaymentMethod();
                $('#home-page').load('../src/views/expense-settings/payment-method.html');
                break;

            case 'payment-category':
                var dataservice = new DataService;
                dataservice.listPaymentCategory();
                $('#home-page').load('../src/views/expense-settings/payment-category.html');
                break;

            case 'payment-type':
                var dataservice = new DataService;
                dataservice.listPaymentType();
                $('#home-page').load('../src/views/expense-settings/payment-type.html');
                break;

            //Income
            case 'settings-income':
                $('#home-page').load('../src/views/settings/income.html');
                break;

            case 'income-recurrence':
                var dataservice = new DataService;
                dataservice.listIncomeRecurrence();
                $('#home-page').load('../src/views/income-settings/income-recurrence.html');
                break;

        }

    }
}

var home = new Home;