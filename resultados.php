<?php

include("backend/sistema.php");

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];
$dias = $votacao["dias"];
$calendarios = $votacao["calendarios"];
$alunos = getAlunos();

$timeleft = strtotime($votacao["termina"]) - strtotime(date("Y-m-d"));

if ($timeleft >= 0) {
    redir("votacao.php?guid=$guid");
}

$totalano = 0;
foreach ($alunos as $moodle => $aluno) {
    if ($aluno["ano"] == $ano) $totalano++;
}

$votaram = array();
$votos = array();
foreach ($votacao["votos"] as $votante => $votado) {
    if (array_key_exists($votado, $votos)) {
        $votos[$votado]++;
    } else {
        $votos[$votado] = 1;
    }
    if (!in_array($votante, $votaram)) {
        array_push($votaram, $votante);
    }
}
function votos($autor) {
    global $votos;
    if (array_key_exists($autor, $votos))
        return $votos[$autor];
    return 0;
}

uasort($calendarios, function($a, $b) {
    global $votos;
    return votos($a["autor"]) < votos($b["autor"]);
});

$criaram = array();
$final = "";
if (count($calendarios) == 0) {
    $final = "Nenhum calendário foi sugerido.";
} else {
    $final = "Os calendários enviados, começando pelos mais bem-avaliados:<br><br><hr>";
    foreach ($calendarios as $moodle => $calendario) {
        $n = 0;
        $autor = $alunos[$moodle];
        array_push($criaram, $moodle);
        $nome = $autor["nome"];
        $sala = $autor["ano"] . "º " . $autor["sala"];
        $final .= "Enviado por <b>$nome</b> ($sala):<br><br><div class=\"sugestao\" id=\"$moodle\">";


        foreach ($dias as $dia) {
            $dat = date("d/m", strtotime($dia));
            $materias = implode("<br>", $calendario["dias"][$n]);
            $final .= "<div class=\"diamaker spc\">
                <div>Dia $dat</div><div class=\"materias\">$materias</div></div><br><br>";
            $n++;
        }
        $final .= "</div><br><b>Total de votos: " . votos($moodle) . "</b><br><br><hr>";
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
        <a class="buttonlink btnorange" href=".">Voltar às votações</a><br>
        <br>
        <br>
        Estes resultados serão usados para definir o calendário de provas para a
        <b><?php echo $etapa; ?>ª etapa do <?php echo $periodo; ?>º período.</b><br><br>
        <br>
        Dos <b><?php echo $totalano; ?></b> alunos do ano, <b><?php echo $totalvotaram ?></b>
        votaram em um calendário, e <b><?php echo $totalcriaram; ?></b>
        enviaram seu próprio.<br>
        <br>
        <?php echo $final; ?>
    </body>
</html>