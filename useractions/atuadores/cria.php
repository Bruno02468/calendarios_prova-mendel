<?php

include("../../backend/sistema.php");

$guid = req_post("guid");

$votacoes = getVotacoes();
$votacao = $votacoes[$guid];

function fail($str) {
    $guid = req_post("guid");
    redir("../criar.php?votid=$guid&err=$str");
}

$moodle = req_post("alunid");
$ano = req_post("sala")[0];
$sala = req_post("sala")[1];
$chamada = req_post("chamada");
$primeiro_nome = req_post("primeironome");

if (!alunoCorreto($primeiro_nome, $ano, $sala, $chamada, $moodle)) fail("Dados de aluno incorretos!");

if ($votacao["ano"] != $ano) fail("Você não é do " . $votacao["ano"] . "º ano!");

$dias = array();
for ($dia = 1; $dia <= 4; $dia++) {
    array_push($dias, array());
    for ($selector = 1; $selector <= 3; $selector ++) {
        $sel = req_post("dia-$dia-$selector");
        if ($sel !== "none") array_push($dias[$dia-1], $sel);
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

redir("../../votacao.php?guid=$guid#$moodle");

?>