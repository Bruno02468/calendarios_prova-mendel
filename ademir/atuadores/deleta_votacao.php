<?php

include("../../backend/sistema.php");

require_login();

$votacoes = getVotacoes();
$guid = req_post("guid");
unset($votacoes[$guid]);
setNewJSON($votacoes, "votacoes.json");

redir("../votacoes.php");

?>