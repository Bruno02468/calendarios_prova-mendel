<?php

include("../backend/sistema.php");

require_login();

$votacoes = getVotacoes();
$links = "";
foreach ($votacoes as $guid => $votacao) {
    $ano = $votacao["ano"];
    $etapa = $votacao["etapa"];
    $periodo = $votacao["periodo"];
    $fin = "";
    if (time() > $votacao["termina"]) {
        $fin = " (FINALIZADA - <a href=\"../resultados.php?votid=$guid\">ver resultados</a>)";
    }
    $links .= "Votação do ${ano}º Ano - ${etapa}ª Etapa do ${periodo}º Período$fin<br>
        <a href=\"editar_votacao?guid=$guid\" class=\"buttonlink btnblue smallbtn\">editar</a> ou
        <a href=\"atuadores/deleta_votacao?guid=$guid\" class=\"buttonlink btnred smallbtn\">deletar</a><br>";
}

?>
<html>
    <head>
        <title>Gerenciando votações</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <center>
            <h1>Gerenciando votações</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href=".">Voltar</a><br>
                <br>
                <br>
                Iniciar uma votação:<br>
                <br>
                <form method="POST" action="atuadores/add_votacao.php">
                    Informações essenciais:<br>
                    Ano: <input type="number" min="1" max="3" name="ano"><br>
                    Etapa: <input type="number" min="1" max="2" name="etapa"><br>
                    Período: <input type="number" min="1" max="4" name="periodo"><br>
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
                    <input class="buttonlink btnblue" type="submit" value="Iniciar uma votação!">
                </form>
                Votações existentes:<br>
                <br>
                <?php echo $editlinks; ?>
            </div>
        </center>
    </body>
</html>