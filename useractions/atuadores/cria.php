<?php

include("../../backend/sistema.php");

$votacoes = getVotacoes();
$alunos = getAlunos();

function fail($str) {
    $guid = req_post("guid");
    $str = urlencode($str);
    redir("../criar.php?votid=$guid&err=$str");
}

$guid = req_post("guid");
$moodle = req_post("alunid");
$ano = req_post("sala")[0];
$sala = req_post("sala")[1];
$chamada = req_post("chamada");
$primeiro_nome = req_post("primeironome");

if (strtotime($votacoes[$guid]["termina"]) < time()) {
    fail("Essa votação já terminou! <a href=\"../../resultados.php?guid=$guid\">Veja os resultados!</a>");
}

if (!alunoCorreto($primeiro_nome, $ano, $sala, $chamada, $moodle)) fail("Dados de aluno incorretos!");

if ($votacoes[$guid]["ano"] != $ano) fail("Você não é do " . $votacoes[$guid]["ano"] . "º ano!");

if (isset($votacoes[$guid]["calendarios"][$moodle])) {
    fail("Você já sugeriu um calendário para essa votação!");
}

$dias = array();
for ($dia = 1; $dia <= 4; $dia++) {
    array_push($dias, array());
    for ($selector = 1; $selector <= 3; $selector ++) {
        $sel = req_post("dia-$dia-$selector");
        if ($sel !== "none") array_push($dias[$dia-1], $sel);
    }
}

foreach ($votacoes[$guid]["calendarios"] as $calendario) {
    $iguais = true;
    for ($dia = 0; $dia < 4; $dia++) {
        if ($dias[$dia] !== $calendario["dias"][$dia]) {
            $iguais = false;
            break;
        }
    }
    if ($iguais) {
        $autor = $alunos[$calendario["autor"]];
        $elemid = $autor["ano"] . $autor["sala"] . $autor["chamada"];
        fail("Um <a href=\"../votacao.php?guid=$guid#$elemid\">calendário equivalente</a> já existe!");
        break;
    }
}

$calendario = array(
    "dias" => $dias,
    "autor" => $moodle,
    "bom" => array(),
    "aceitavel" => array(),
    "ruim" => array(),
    "deletado" => false
);

$votacoes[$guid]["calendarios"][$moodle] = $calendario;
setVotacoes($votacoes);

redir("../../votacao.php?guid=$guid#${ano}${sala}${chamada}");

?>