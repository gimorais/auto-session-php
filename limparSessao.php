<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: menu.php#limparSessao");
        exit;
    }

    unset($_SESSION["marcas"]);
    unset($_SESSION["modelos"]);
    unset($_SESSION["ultima_marca"]);

    header("Location: menu.php?msg=sessao_limpa#limparSessao");
    exit;
?>