<?php

include("../../backend/sistema.php");

require_login();

setAluno($matricula, array(
    "nome" => req_post("nome"),
    "ano" => req_post("ano"),
    "sala" => req_post("sala"),
    "chamada" => req_post("chamada")
));

redir("../alunos.php");

?>