<?php
// session_start();

// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header("Location: index.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagicMoney</title>

    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/test.css">

</head>

<body>

    <div class="home">









































        <div class="page" id="home-page">








        </div>




































        <div class="bottom-menu">
            <div class="menu-item active" id="general">
                <img src="../src/assets/money-mangement.png">
                <span>Geral</span>
            </div>

            <div class="menu-item" id="income" onclick="home.loadPage('income')">
                <img src="../src/assets/income.png">
                <span>Receitas</span>
            </div>

            <div class="menu-item" id="expenses" onclick="home.loadPage('expenses')">
                <img src="../src/assets/expenses-in-business.png">
                <span>Despesas</span>
            </div>

            <div class="menu-item" id="investments">
                <img src="../src/assets/currency.png">
                <span>Investimentos</span>
            </div>

            <div class="menu-item" id="settings" onclick="home.loadPage('settings')">
                <img src="../src/assets/settings.png">
                <span>Ajustes</span>
            </div>
        </div>

    </div>

    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/Home.js"></script>
    <script src="./js/Generic.js"></script>

    <script>
        $('.menu-item').on('click', function() {
            $('.menu-item').removeClass('active');
            $(this).addClass('active');
        });
    </script>

</body>

</html>