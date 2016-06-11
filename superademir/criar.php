<?php

include("../backend/sistema.php");

require_login("borginhos");

?>

<html>
    <head>
        <title>Painel Superadministrativo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>

    <body>
        <center>
            <h1>Criando login</h1>
            <br>
            <form method="POST" action="atuadores/cria.php">
                Nome: <input type="text" name="nome"><br>
                Senha: <input type="password" name="pass"><br>
                <br>
                <input class="buttonlink" type="submit" value="Criar!">
            </form>
        </center>
    </body>
</html>