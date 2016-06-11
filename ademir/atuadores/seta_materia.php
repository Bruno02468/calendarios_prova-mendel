<?php

include("../../backend/sistema.php");

require_login();

$anos = array();
for ($ano = 1; $ano <= 3; $ano++) {
    if (isset($_POST["ano$ano"])) array_push($anos, "$ano");
}

setMateria(req_post("nome"), array(
    "natureza" => req_post("natureza"),
    "curta" => isset($_POST["curta"]),
    "anos" => $anos
));

redir("../materias.php");

?>