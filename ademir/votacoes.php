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
    $timeleft = strtotime($votacao["termina"]) - strtotime(date("Y-m-d"));
    if ($timeleft < 0) {
        $fin = " (FINALIZADA - <a href=\"../resultados.php?guid=$guid\">ver resultados</a>)";
    }
    $links .= "Votação do ${ano}º Ano - ${etapa}ª Etapa do ${periodo}º Período$fin<br>
        <a href=\"editar_votacao.php?guid=$guid\" class=\"buttonlink btnblue smallbtn\">editar</a> ou
        <a href=\"atuadores/deleta_votacao.php?guid=$guid\" class=\"buttonlink btnred smallbtn\">deletar</a><br><br>";
}

?>
<html>
    <head>
        <title>Gerenciar votações</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <center>
            <h1>Gerenciar votações</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href=".">Voltar</a><br>
                <br>
                <br>
                <a class="buttonlink btngreen bigbtn" href="criar_votacao.php">Iniciar votação</a><br>
                <br>
                <br>
                Votações existentes:<br>
                <br>
                <?php echo $links; ?>
            </div>
        </center>
    </body>
</html>