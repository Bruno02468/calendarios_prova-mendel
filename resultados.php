<?php

include("backend/sistema.php");

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];
$dias = $votacao["dias"];
$calendarios = ordenarCalendarios($votacao["calendarios"]);
$alunos = getAlunos();

if (strtotime($votacao["termina"]) > time()) {
    redir("votacao.php?guid=$guid");
}

$totalano = 0;
foreach ($alunos as $moodle => $aluno) {
    if ($aluno["ano"] == $ano) $totalano++;
}

$opinioes = array("bom", "aceitavel", "ruim");
$votaram = array();
$criaram = array();
$final = "";
if (count($calendarios) == 0) {
    $final = "Nenhum calendário foi sugerido.";
} else {
    $final = "Os calendários sugeridos, começando pelos mais bem-avaliados:<br><br><hr>";
    foreach ($calendarios as $moodle => $calendario) {
        $n = 0;
        $autor = $alunos[$moodle];
        array_push($criaram, $moodle);
        $nome = $autor["nome"];
        $sala = $autor["ano"] . "º " . $autor["sala"];
        $final .= "Enviado por <b>$nome</b> ($sala):<br><br><div class=\"sugestao\" id=\"$moodle\">";
        $b = count($calendario["bom"]);
        $a = count($calendario["aceitavel"]);
        $r = count($calendario["ruim"]);
        
        foreach ($opinioes as $opiniao) {
            foreach ($calendario[$opiniao] as $vmoodle) {
                if (!in_array($vmoodle, $votaram)) {
                    array_push($votaram, $vmoodle);
                }
            }
        }

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

$totalvotaram = count($votaram);
$totalcriaram = count($criaram);

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
        <?php include_once("backend/analytics.php") ?>
        <h1>Resultados da Votação</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <br>
        Estes resultados serão usados para definir o calendário de provas para a
        <b><?php echo $etapa; ?>ª etapa do <?php echo $periodo; ?>º período.</b><br><br>
        <br>
        Dos <b><?php echo $totalano; ?></b> alunos do ano, <b><?php echo $totalvotaram ?></b> 
        votaram em pelo menos um calendário, e <b><?php echo $totalcriaram; ?></b>
        enviaram seu próprio.<br>
        <br>
        <?php echo $final; ?>
    </body>
</html>