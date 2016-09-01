<?php

include("../../backend/sistema.php");

$votacoes = getVotacoes();

$guid = req_post("guid");
$autor = req_post("autor");

function fail($str) {
    $guid = req_post("guid");
    $autor = req_post("autor");
    redir("../votar.php?votid=$guid&autor=$autor&err=$str");
}

if (strtotime($votacoes[$guid]["termina"]) < time()) {
    fail("Essa votação já terminou! <a href=\"../../resultados.php?guid=$guid\">Veja os resultados!</a>");
}

$moodle = req_post("alunid");
$ano = req_post("sala")[0];
$sala = req_post("sala")[1];
$chamada = req_post("chamada");
$primeiro_nome = trim(req_post("primeironome"));

if (!alunoCorreto($primeiro_nome, $ano, $sala, $chamada, $moodle)) fail("Dados de aluno incorretos!");

if ($votacoes[$guid]["ano"] != $ano) fail("Você não é do " . $votacoes[$guid]["ano"] . "º ano!");

$votacoes[$guid]["votos"][$moodle] = $autor;

setVotacoes($votacoes);

redir("../../votacao.php?guid=$guid#${ano}${sala}${chamada}");

?>