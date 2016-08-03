<?php

include("../backend/sistema.php");

require_login();

?>
<html>
    <head>
        <title>Mover aluno</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <center>
            <h1>Mover aluno</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href=".">Voltar</a><br>
                <br>
                <br>
                <div style="font-size: 75%; font-weight: normal;">
                Alunos são indexados pelo login do Moodle.<br>
                <br>
                Quando ocorre fraude de voto, é porque algum outro aluno soube se autenticar como outro.<br>
                <br>
                Para evitar que esse mesmo aluno seja vítima de novo, pode ser mudado seu "número" para qualquer outra coisa.<br>
                <br>
                Para se autenticar e poder votar, o aluno vai usar esse novo número, e não seu login do Moodle.<br>
                <br>
                Antes de fazer tal mudança, é bom comunicar ao aluno que ele deve colocar esse novo número no lugar de seu login do Moodle.
                <br>
                <br>
                <br>
            </div>
            <form action="atuadores/move_aluno.php" method="POST">
                Login do Moodle/ID atual do aluno: <input type="text" name="current"><br>
                Novo ID para o aluno: <input type="text" name="new"><br>
                <input class="buttonlink btnblue" type="submit" value="Salvar mudança">
            </form>
            </div>
        </center>
    </body>
</html>