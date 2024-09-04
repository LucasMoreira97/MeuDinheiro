<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagicMoney</title>

    <link rel="stylesheet" href="./css/login.css">

</head>

<body>

    <div class="container" id="container">

        <div class="form-container sign-up">

            <form id="sign-up">
                <h1>Criar Conta</h1>

                <span>Ou, use o seu email para se registrar</span>
                <input type="text" placeholder="Nome">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Senha">
                <button>Criar uma conta</button>

            </form>

        </div>

        <div class="form-container sign-in">

            <form id="sign-in" onsubmit="login(event)">
                <h1>Entrar</h1>

                <span>Ou, use o seu email para entrar</span>
                <input type="email" id="email" placeholder="Email" value="l@a">
                <input type="password" id="password" placeholder="Senha" value="1">

                <a href="#">Esqueci a minha senha</a>

                <button type="submit">Entrar</button>



            </form>

        </div>

        <div class="toggle-container">

            <div class="toggle">


                <div class="toggle-panel toggle-left">

                    <h1>Bem vindo de volta!</h1>
                    <p>Sua jornada financeira continua aqui.</p>

                    <button class="hidden" id="login">Entrar</button>

                </div>

                <div class="toggle-panel toggle-right">

                    <h1>Olá, seja bem vindo!</h1>
                    <p>Sua jornada financeira continua aqui.</p>

                    <button class="hidden" id="register">Criar uma conta</button>

                </div>



            </div>


        </div>




    </div>

    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/login.js"></script>
    <script src="./js/LoginScreen.js"></script>

</body>

</html>

<?php
