<?php

include("../../backend/sistema.php");

require_login("borginhos");

$nome = req_get("nome");

if ($nome == "borginhos") {
    die("nao se deleta o borginhos huehuehue");
}

removeCredencial($nome);

redir("..");

?>