<?php

include("../backend/sistema.php");

require_login();

?>
<html>
    <head>
        <title>Iniciar votação</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <center>
            <h1>Iniciar votação</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href="votacoes.php">Voltar às votações</a><br>
                <br>
                <br>
                <form method="POST" action="atuadores/adiciona_votacao.php">
                    Informações essenciais:<br>
                    Ano:
                    <select name="ano">
                        <option value="1">1°</option>
                        <option value="2">2°</option>
                        <option value="2">3°</option>
                    </select>
                    <br>
                    Período:
                    <select name="periodo">
                        <option value="1">1°</option>
                        <option value="2">2°</option>
                        <option value="3">3°</option>
                        <option value="4">4°</option>
                    </select>
                    <br>
                    Etapa:
                    <select name="etapa">
                        <option value="1">1ª</option>
                        <option value="2">2ª</option>
                    </select>
                    <br>
                    Período de votação:<br>
                    Começa: <input type="date" name="comeca"><br>
                    Termina: <input type="date" name="termina"><br>
                    <br>
                    Dias de prova:<br>
                    1º: <input type="date" name="dia1"><br>
                    2º: <input type="date" name="dia2"><br>
                    3º: <input type="date" name="dia3"><br>
                    4º: <input type="date" name="dia4"><br>
                    <br>
                    <input class="buttonlink btnblue" type="submit" value="Iniciar votação!">
                </form>
            </div>
        </center>
    </body>
</html>