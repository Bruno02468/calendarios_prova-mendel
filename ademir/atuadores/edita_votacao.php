<?php

include("../../backend/sistema.php");

require_login();

$dia1 = req_post("dia1");
$dia2 = req_post("dia2");
$dia3 = req_post("dia3");
$dia4 = req_post("dia4");
$guid = req_post("guid");

$votacoes = getVotacoes();

$votacoes[$guid] = array(
    "ano" => req_post("ano"),
    "etapa" => req_post("etapa"),
    "periodo" => req_post("periodo"),
    "comeca" => req_post("comeca"),
    "termina" => req_post("termina"),
    "dias" => array($dia1, $dia2, $dia3, $dia4),
    "calendarios" => $votacoes[$guid]["calendarios"]
);

setVotacoes($votacoes);

redir("../votacoes.php");

?>