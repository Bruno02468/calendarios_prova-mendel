<?php

include("../backend/sistema.php");

require_login();

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];


?>
<html>
    <head>
        <title>Editando votação</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <center>
            <h1>Editando votação do <?php echo $votacao["ano"]; ?>º Ano</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href=".">Voltar</a><br>
                <br>
                <br>
                Iniciar uma votação:<br>
                <br>
                <form method="POST" action="atuadores/edita_votacao.php">
                    Informações essenciais:<br>
                    Ano: <input type="number" min="1" max="3" name="ano" value="<?php echo $votacao["ano"]; ?>"><br>
                    Etapa: <input type="number" min="1" max="2" name="etapa" value="<?php echo $votacao["etapa"]; ?>"><br>
                    Período: <input type="number" min="1" max="4" name="periodo" value="<?php echo $votacao["periodo"]; ?>"><br>
                    <br>
                    Período de votação:<br>
                    Começa: <input type="date" name="comeca" value="<?php echo $votacao["comeca"]; ?>"><br>
                    Termina: <input type="date" name="termina" value="<?php echo $votacao["termina"]; ?>"><br>
                    <br>
                    Dias de prova:<br>
                    1º: <input type="date" name="dia1" value="<?php echo $votacao["dias"][0]; ?>"><br>
                    2º: <input type="date" name="dia2" value="<?php echo $votacao["dias"][1]; ?>"><br>
                    3º: <input type="date" name="dia3" value="<?php echo $votacao["dias"][2]; ?>"><br>
                    4º: <input type="date" name="dia4" value="<?php echo $votacao["dias"][3]; ?>"><br>
                    <br>
                    <input type="hidden" value="<?php echo $guid; ?>" name="guid">
                    <input class="buttonlink btnblue" type="submit" value="Salvar alterações">
                </form>
            </div>
        </center>
    </body>
</html>