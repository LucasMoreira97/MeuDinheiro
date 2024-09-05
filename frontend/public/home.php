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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-0bRV2YaxJhTFZu0DVP1TnATu1SoW0HhiF7ABkKByhT+Vh0C7Rx82yYTp7x0mFNCx" crossorigin="anonymous">

</head>

<body>


    <div class="page">



    </div>

    <div class="menu">
        <ul>
            <li onclick="home.test()">Saúde financeira</li>
            <li onclick="home.addIncomePage()">Receitas</li>
            <li>Despesas</li>
            <li>Investimentos</li>
            <li>Perfil</li>
        </ul>
    </div>


    <script src="./js/Home.js"></script>

</body>

</html>