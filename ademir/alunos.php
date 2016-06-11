<?php

include("../backend/sistema.php");

require_login();

?>
<html>
    <head>
        <title>Gerenciando alunos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <center>
            <h1>Gerenciando alunos</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href=".">Voltar</a><br>
                <br>
                <br>
                Setar aluno:<br>
                <br>
                <form method="POST" action="atuadores/seta_aluno.php">
                    Matrícula: <input type="text" name="matricula"><br>
                    Nome: <input type="text" name="nome"><br>
                    Ano: <input type="number" min="1" max="3" name="ano"><br>
                    Sala: <input type="text" name="sala"><br>
                    Número de chamada: <input type="text" name="chamada"><br>
                    <input class="buttonlink btnblue" type="submit" value="Salvar">
                <br>
            </div>
        </center>
    </body>
</html>