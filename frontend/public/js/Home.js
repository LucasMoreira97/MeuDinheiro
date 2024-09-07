class Home {

    constructor() {
        this.view = '../src/views/';
    }

    test() {
        // alert('nova pagina');
    }

    loadPage(page) {
        $('#home-page').load(this.view + page + '.html');
    }
}

var home = new Home;