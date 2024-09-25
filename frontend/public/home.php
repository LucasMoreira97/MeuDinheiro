<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
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
        <div class="page" id="home-page"></div>
    </div>

    <div class="bottom-menu">
        <div class="menu-item active general">
            <img src="../src/assets/general_menu.png">
            <span>Geral</span>
        </div>

        <div class="menu-item income" onclick="home.loadPage('income')">
            <img src="../src/assets/income.png">
            <span>Receitas</span>
        </div>

        <div class="menu-item expenses" onclick="home.loadPage('expenses')">
            <img src="../src/assets/expenses.png">
            <span>Despesas</span>
        </div>

        <div class="menu-item investments">
            <img src="../src/assets/investment.png">
            <span>Aportes</span>
        </div>

        <div class="menu-item settings" onclick="home.loadPage('settings')">
            <img src="../src/assets/settings.png">
            <span>Ajustes</span>
        </div>
    </div>


    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/Home.js"></script>
    <script src="./js/Generic.js"></script>
    <script src="./js/ShowElement.js"></script>
    <script src="./js/DataService.js"></script>

    <script>
        $('.menu-item').on('click', function() {
            $('.menu-item').removeClass('active');
            $(this).addClass('active');
        });
    </script>

</body>

</html>