<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Dinheiro - Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="container">
        <!-- Formulário de Login -->
        <div class="form-container" id="login-form">
            <form id="sign-in" onsubmit="login(event)">
                <h1>Entrar</h1>
                <span>Ou, use o seu email para entrar</span>
                <input type="email" id="email" placeholder="Email" value="">
                <input type="password" id="password" placeholder="Senha" value="">
                <a href="#">Esqueci a minha senha</a>
                <button type="submit">Entrar</button>
                <p>Não tem uma conta? <a href="#" id="show-register">Cadastre-se</a></p>
            </form>
        </div>
        <!-- Formulário de Cadastro -->
        <div class="form-container" id="register-form" style="display: none;">
            <form id="sign-up">
                <h1>Criar Conta</h1>
                <span>Ou, use o seu email para se registrar</span>
                <input type="text" placeholder="Nome">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Senha">
                <button type="submit">Criar uma conta</button>
                <p>Já tem uma conta? <a href="#" id="show-login">Entrar</a></p>
            </form>
        </div>
    </div>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/LoginScreen.js"></script>
</body>
</html>
