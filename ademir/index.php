<?php

include("../backend/sistema.php");

require_login();

?>
<html>
    <head>
        <title>Painel Administrativo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <center>
            <h1>Painel Administrativo</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink bigbtn" href="alunos.php">Alunos</a><br>
                <br>
                <a class="buttonlink bigbtn" href="materias.php">Matérias</a><br>
                <br>
                <a class="buttonlink bigbtn" href="votacoes.php">Votações</a><br>
                <br>
            </div>
        </center>
    </body>
</html>