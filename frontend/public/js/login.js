
const container = document.getElementById('container');
const register_btn = document.getElementById('register');
const login_btn = document.getElementById('login');

register_btn.addEventListener('click', () =>{
    container.classList.add("active");
});

login_btn.addEventListener('click', () =>{
    container.classList.remove("active");
});


document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('sign-in').addEventListener('submit', function(event) {
        event.preventDefault();

        console.log('tentando logar');

        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        fetch('/MagicMoney/backend/router.php/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email, password: password })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // window.location.href = 'home.php';
                console.log('loguei');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Ocorreu um erro ao tentar fazer o login.');
        });
    });
});

