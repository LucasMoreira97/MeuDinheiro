async function login(event) {
    event.preventDefault();

    var email = $('#email').val();
    var password = $('#password').val();

    const uri = '/MagicMoney/backend/router.php/login';
    const response = await fetch(uri, {
        method: 'POST',
        headers: { 'content-type': 'application/json' },
        body: JSON.stringify({
            email: email, password: password
        })
    });

    const data = await response.json();

    if(data.success == true){

        alert('usuário logado');
        window.location.href = 'home.php';

    }else{
        alert('erro ao logar');
    }

}
