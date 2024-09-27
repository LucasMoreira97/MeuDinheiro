class Home {

    async loadPage(page) {

        switch (page) {

            case 'income':
                $('#home-page').load('../src/views/' + page + '.html', function () {
                    var dataservice = new DataService;
                    var generic = new Generic;
                    
                    generic.setTodayDate('income-date');
                    dataservice.selectIncomeRecurrence();
                    dataservice.selectUserGroupUsers();
                });
                break;

            case 'expenses':
            case 'investments':
            case 'settings':
                $('#home-page').load('../src/views/' + page + '.html');
                break;

            case 'settings-profile':
                var dataservice = new DataService;
                dataservice.userProfileData();
                $('#home-page').load('../src/views/settings/profile.html');
                break;

            //Expenses
            case 'settings-expenses':
                $('#home-page').load('../src/views/settings/expenses.html');
                break;

            //About
            case 'settings-about':
                $('#home-page').load('../src/views/settings/about.html');
                break;

            //Feedback
            case 'settings-feedback':
                $('#home-page').load('../src/views/settings/feedback.html', function () {
                    $('#type-feedback, #message-feedback').on('input', generic.inputsToSendFeedback);
                });

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

            //General
            case 'settings-general':
                $('#home-page').load('../src/views/settings/general.html');
                break;

            case 'managment-group':
                var dataservice = new DataService;
                dataservice.listUserGroupUsers();
                $('#home-page').load('../src/views/general-settings/managment-group.html');
                break;

            case 'update-password':
                $('#home-page').load('../src/views/general-settings/update-password.html');
                break;

            case 'delete-account':
                $('#home-page').load('../src/views/general-settings/delete-account.html', function () {
                    $('#confirm-email, #confirm-password').on('input', generic.inputsToDeleteAccount);
                });

                break;
        }

    }
}

var home = new Home;