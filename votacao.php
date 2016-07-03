<?php

include("backend/sistema.php");

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];
$dias = $votacao["dias"];

$calendarios = $votacao["calendarios"];

if (count($calendarios) == 0) {
    $final = "Nenhum calendário foi sugerido ainda.<br>
        <b>É a sua chance de brilhar, <a href=\"useractions/criar.php?votid=$guid\">crie o primeiro!</a></b>";
} else {
    $final = "<a class=\"buttonlink btngreen\" href=\"useractions/criar.php?votid=$guid\">
        Sugerir um calendário</a><br><br>Sugestões dos outros alunos:<br><br>";

    foreach ($calendarios as $moodle => $calendario) {
        $n = 0;
        $autor = getAlunos()[$moodle];
        $nome = $autor["nome"];
        $sala = $autor["ano"] . "º " . $autor["sala"];
        $final .= "<div class=\"sugestao\" id=\"$moodle\">";
        $b = count($calendario["bom"]);
        $a = count($calendario["aceitavel"]);
        $r = count($calendario["ruim"]);
        $bom = "<a class=\"buttonlink smallbtn\"
            href=\"useractions/votar.php?votid=$guid&autor=$moodle&opiniao=bom\">bom</a>";
        $aceitavel = "<a class=\"buttonlink btnorange smallbtn\"
            href=\"useractions/votar.php?votid=$guid&autor=$moodle&opiniao=aceitavel\">aceitável</a>";
        $ruim = "<a class=\"buttonlink btnred smallbtn\"
            href=\"useractions/votar.php?votid=$guid&autor=$moodle&opiniao=ruim\">ruim</a>";

        foreach ($dias as $dia) {
            $dat = date("d/m", strtotime($dia));
            $materias = implode("<br>", $calendario["dias"][$n]);
            $final .= "<div class=\"diamaker spc\">
                <div>Dia $dat</div><div class=\"materias\">$materias</div></div><br><br>";
            $n++;
        }

        $final .= "</div><br>Sugerido por <b>$nome</b> ($sala)<br>
        <br>O que você achou desse calendário?<br>
        <table>
            <tr><td>$bom</td><td>$aceitavel</td><td>$ruim</td></tr>
            <tr style=\"text-align: center;\"><td>$b</td><td>$a</td><td>$r</td></tr>
        </table>";
    }
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
        <?php echo $final; ?>
    </body>
</html>