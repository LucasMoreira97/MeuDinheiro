class Home {

    loadPage(page) {

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


                
        }

    }
}

var home = new Home;