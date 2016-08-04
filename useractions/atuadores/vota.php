<?php

include("../../backend/sistema.php");

$votacoes = getVotacoes();

$guid = req_post("guid");
$autor = req_post("autor");
$opiniao = req_post("opiniao");
$possiveis = array("bom", "aceitavel", "ruim");

function fail($str) {
    $guid = req_post("guid");
    redir("../votar.php?votid=$guid&autor=$autor&opiniao=$opiniao&err=$str");
}

if (!in_array($opiniao, $possiveis)) fail("Hackear é feio!");

if (strtotime($votacoes[$guid]["termina"]) < time()) {
    fail("Essa votação já terminou! <a href=\"../../resultados.php?guid=$guid\">Veja os resultados!</a>");
}

$moodle = req_post("alunid");
$ano = req_post("sala")[0];
$sala = req_post("sala")[1];
$chamada = req_post("chamada");
$primeiro_nome = req_post("primeironome");

if (!alunoCorreto($primeiro_nome, $ano, $sala, $chamada, $moodle)) fail("Dados de aluno incorretos!");

if ($votacoes[$guid]["ano"] != $ano) fail("Você não é do " . $votacoes[$guid]["ano"] . "º ano!");

foreach($possiveis as $op) {
    if (($i = array_search($moodle, $votacoes[$guid]["calendarios"][$autor][$op])) !== false) {
        unset($votacoes[$guid]["calendarios"][$autor][$op][$i]);
    }
}

array_push($votacoes[$guid]["calendarios"][$autor][$opiniao], $moodle);

setVotacoes($votacoes);

redir("../../votacao.php?guid=$guid#${ano}${sala}${chamada}");

?>