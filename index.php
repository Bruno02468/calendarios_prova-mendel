<?php

include("backend/sistema.php");

$votacoes = getVotacoes();
uasort($votacoes, function($a, $b) {
    return $a["ano"] > $b["ano"];
});


$vots = "";
foreach ($votacoes as $guid => $votacao) {
    if (strtotime($votacao["comeca"]) > time()) continue;
    $ano = $votacao["ano"];
    $periodo = $votacao["periodo"];
    $etapa = $votacao["etapa"];
    $anostamp = "<b>${ano}º ano</b> - ${periodo}º período da ${etapa}ª etapa";
    
    $timeleft = strtotime($votacao["termina"]) - time();
    $diasleft = ceil($timeleft / 86400);
    
    if ($timeleft > 0) {
        $vots .= "<a class=\"buttonlink bigbtn\" href=\"votacao.php?guid=$guid\">$anostamp</a>
        <br><br>($diasleft dias restantes para votar)<br><br><br>";
    } else {
        $vots .= "<a class=\"buttonlink btnorange bigbtn\" href=\"votacao.php?guid=$guid\">$anostamp</a>
        <br><br>(ver resultado)<br><br><br>";
    }
    
}

if ($vots == "") $vots = "<i>Nenhuma votação ativa agora.</i>"

?>
<html>
    <head>
        <title>Calendários de Prova</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body style="text-align: center;">
        <h1>Votações para os Calendários de Prova</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <br>
        Aqui você participa diretamente do processo de escolha do calendário de provas!<br>
        <br>
        <br>
        <?php echo $vots; ?>
    </body>
</html>