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

if (strtotime($votacao["termina"]) < time()) {
    redir("resultados.php?guid=$guid");
}

$final = "";
if (count($calendarios) == 0) {
    $final = "<br>Nenhum calendário foi sugerido ainda.<br>
        <b>É a sua chance de brilhar, <a href=\"useractions/criar.php?votid=$guid\">crie o primeiro!</a></b>";
} else {
    $final = "<b>Procure maximizar sua opinião votando em <u>todos</u> os calendários!</b><br>
        <br><a class=\"buttonlink btngreen\" href=\"useractions/criar.php?votid=$guid\">
        Sugerir um calendário</a><br><br><br>";
    foreach ($calendarios as $moodle => $calendario) {
        $n = 0;
        $autor = $alunos[$moodle];
        $nome = $autor["nome"];
        $sala = $autor["ano"] . "º " . $autor["sala"];
        $elemid = $autor["ano"] . $autor["sala"] . $autor["chamada"];
        $final .= "<span id=\"$elemid\">Sugerido por <b>$nome</b> ($sala):</span><br><br><div class=\"sugestao\">";
        $b = count($calendario["bom"]);
        $a = count($calendario["aceitavel"]);
        $r = count($calendario["ruim"]);
        $totalvotos = $b+$a+$r;
        $pbom = round($b/$totalvotos*100);
        $paceitavel = round($a/$totalvotos*100);
        $pruim = round($r/$totalvotos*100);
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

        $final .= "</div><br>O que você achou desse calendário?<br>
        <table>
            <tr><td>$bom</td><td>$aceitavel</td><td>$ruim</td></tr>
            <tr style=\"text-align: center;\">
                <td class=\"bom\">$pbom%</td>
                <td class=\"aceitavel\">$paceitavel%</td>
                <td class=\"ruim\">$pruim%</td>
            </tr>
        </table><br><br><hr>";
    }
    $final .= "<br>Nenhum desses calendários ficou bom?<br>
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