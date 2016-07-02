<?php

include("../../backend/sistema.php");

require_login();

$votacoes = getVotacoes();
$guid = req_get("guid");
unset($votacoes[$guid]);
setNewJSON($votacoes, "votacoes.json");

redir("../votacoes.php");

?>