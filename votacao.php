<?php

include("backend/sistema.php");

$guid = req_get("guid");
$votacao = getVotacoes()[$guid];
$calendarios = $votacao["calendarios"];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];
$dias = $votacao["dias"];
$alunos = getAlunos();

$timeleft = strtotime($votacao["termina"]) - strtotime(date("Y-m-d"));

if ($timeleft < 0) {
    redir("resultados.php?guid=$guid");
}

uasort($calendarios, function($a, $b) {
    return $a["criado"] < $b["criado"];
});

$final = "";
if (count($calendarios) == 0) {
    $final = "Nenhum calendário foi sugerido ainda.<br>
        <b>É a sua chance de brilhar, <a href=\"useractions/criar.php?votid=$guid\">crie o primeiro!</a></b>";
} else {
    $final = "<a class=\"buttonlink btngreen\" href=\"useractions/criar.php?votid=$guid\">
        Enviar um calendário</a><br><br><br>";
    foreach ($calendarios as $moodle => $calendario) {
        $n = 0;
        $autor = $alunos[$moodle];
        $nome = $autor["nome"];
        $sala = $autor["ano"] . "º " . $autor["sala"];
        $elemid = $autor["ano"] . $autor["sala"] . $autor["chamada"];
        $final .= "<span id=\"$elemid\">Enviado por <b>$nome</b> ($sala):</span><br><br><div class=\"sugestao\">";

        foreach ($dias as $dia) {
            $dat = date("d/m", strtotime($dia));
            $materias = implode("<br>", $calendario["dias"][$n]);
            $final .= "<div class=\"diamaker spc\">
                <div>Dia $dat</div><div class=\"materias\">$materias</div></div><br><br>";
            $n++;
        }

        $final .= "</div><br>Prefere esse calendário?<br>
        <br><a class=\"buttonlink btngreen smallbtn\" href=\"useractions/votar.php?votid=$guid&autor=$moodle\">
        Fazer dele a minha escolha!</a><br><br><hr>";
    }
    $final .= "<br><br><br>Nenhum desses calendários ficou do seu agrado?<br>
        Sem problema, <a href=\"useractions/criar.php?votid=$guid\">crie o seu próprio</a>!<br><br>";
}


?>
<html>
    <head>
        <title>Votação do <?php echo $ano; ?>º Ano</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <?php include_once("backend/analytics.php") ?>
        <h1>Votação do <?php echo $ano; ?>º Ano</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <a class="buttonlink btnorange" href=".">Voltar às votações</a><br>
        <br>
        <br>
        Esta votação será usada para definir o calendário de provas para a
        <b><?php echo $etapa; ?>ª etapa do <?php echo $periodo; ?>º período.</b><br>
        <br>
        <?php echo $final; ?>
    </body>
</html>