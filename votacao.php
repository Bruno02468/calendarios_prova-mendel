<?php

include("backend/sistema.php");

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];

$calendarios = $votacao["calendarios"];

if (count($calendarios) == 0) {
    $final = "Nenhum calendário foi sugerido ainda.<br>
        <b>É a sua chance de brilhar, <a href=\"useractions/criar.php?votid=$guid\">crie o primeiro!</a></b>";
} else {
    $final = "<a class=\"buttonlink btngreen\" href=\"useractions/criar.php?votid=$guid\">Sugerir um calendário</a>";
    
}
    

?>
<html>
    <head>
        <title>Votação do <?php echo $ano; ?>º ano</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body style="text-align: center;">
        <h1>Votação do <?php echo $ano; ?>º ano</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <br>
        Esta votação será usada para definir o calendário de provas para a
        <b><?php echo $etapa; ?>ª etapa do <?php echo $periodo; ?>º período.</b><br>
        <br>
        <br>
        <?php echo $final; ?>
    </body>
</html>