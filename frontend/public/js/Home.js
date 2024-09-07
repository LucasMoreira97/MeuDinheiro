class Home {

    constructor() {
        this.view = '../src/views/';
    }

    test() {
        // alert('nova pagina');
    }

    addIncomePage() {
        $('#home-page').load(this.view + 'income.html');
    }

    addExpensePage() {

        $('#home-page').load(this.view + 'expense.html');


    }

}

var home = new Home;