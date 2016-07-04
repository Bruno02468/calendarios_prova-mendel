<?php

include("backend/sistema.php");

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];
$dias = $votacao["dias"];

$calendarios = $votacao["calendarios"];
uasort($calendarios, function($a, $b) {
    $a_bom = count($a["bom"]);
    $b_bom = count($b["bom"]);
    $a_aceitavel = count($a["aceitavel"]);
    $b_aceitavel = count($b["aceitavel"]);
    $a_ruim = count($a["ruim"]);
    $b_ruim = count($b["ruim"]);
    if ($a_bom > $b_bom) return -1;
    if ($a_bom < $b_bom) return 1;
    if ($a_bom == $b_bom) {
        if ($a_aceitavel > $b_aceitavel) return -1;
        if ($a_aceitavel < $b_aceitavel) return 1;
        if ($a_aceitavel == $b_aceitavel) {
            if ($a_ruim < $b_ruim) return -1;
            if ($a_ruim > $b_ruim) return 1;
        }
    }
    return 0;
});

$final = "";
if (count($calendarios) == 0) {
    $final = "Nenhum calendário foi sugerido.";
} else {
    $final = "Calendários mais bem-avaliados:<br><br>";
    foreach ($calendarios as $moodle => $calendario) {
        $n = 0;
        $autor = getAlunos()[$moodle];
        $nome = $autor["nome"];
        $sala = $autor["ano"] . "º " . $autor["sala"];
        $final .= "Sugestão de <b>$nome</b> ($sala):<br><br><div class=\"sugestao\" id=\"$moodle\">";
        $b = count($calendario["bom"]);
        $a = count($calendario["aceitavel"]);
        $r = count($calendario["ruim"]);

        foreach ($dias as $dia) {
            $dat = date("d/m", strtotime($dia));
            $materias = implode("<br>", $calendario["dias"][$n]);
            $final .= "<div class=\"diamaker spc\">
                <div>Dia $dat</div><div class=\"materias\">$materias</div></div><br><br>";
            $n++;
        }

        $final .= "</div><br>O que as pessoas acharam desse calendário:<br>
        <table>
            <tr class=\"vot bom\"><td>Bom: </td><td>$b</td></tr>
            <tr class=\"vot aceitavel\"><td>Aceitável: </td><td>$a</td></tr>
            <tr class=\"vot ruim\"><td>Ruim: </td><td>$r</td></tr>
        </table><br><br><hr>";
    }
}


?>
<html>
    <head>
        <title>Resultados da Votação</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Resultados da Votação</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <br>
        Esses resultados serão usada para definir o calendário de provas para a
        <b><?php echo $etapa; ?>ª etapa do <?php echo $periodo; ?>º período.</b><br>
        <br>
        <?php echo $final; ?>
    </body>
</html>