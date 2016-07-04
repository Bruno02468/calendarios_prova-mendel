<?php

include("../backend/sistema.php");

require_login();

$votacoes = getVotacoes();
$links = "";
foreach ($votacoes as $guid => $votacao) {
    $ano = $votacao["ano"];
    $etapa = $votacao["etapa"];
    $periodo = $votacao["periodo"];
    $fin = " <i>(em andamento)</i>";
    if (time() > strtotime($votacao["termina"])) {
        $fin = " (FINALIZADA - <a href=\"../resultados.php?guid=$guid\">ver resultados</a>)";
    }
    $links .= "Votação do ${ano}º Ano - ${etapa}ª Etapa do ${periodo}º Período$fin<br>
        <a href=\"editar_votacao.php?guid=$guid\" class=\"buttonlink btnblue smallbtn\">editar</a> ou
        <a href=\"atuadores/deleta_votacao.php?guid=$guid\" class=\"buttonlink btnred smallbtn\">deletar</a><br><br>";
}

?>
<html>
    <head>
        <title>Gerenciando votações</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
                    <input class="buttonlink btnblue" type="submit" value="Iniciar uma votação!">
                </form>
                Votações existentes:<br>
                <br>
                <?php echo $links; ?>
            </div>
        </center>
    </body>
</html>