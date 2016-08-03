<?php

include("../../backend/sistema.php");

require_login();

$current = req_post("current");
$new = req_post("new");

$alunos = getAlunos();

if (!array_key_exists($current, $alunos)) {
    die("Não existe um aluno com o ID atual especificado.");
}
if (array_key_exists($new, $alunos)) {
    die("Já existe um aluno com o novo ID especificado.");
}
if (trim($new) == "") {
    die("ID vazio é feio! Tente algo mais longo que nada.");
}
if (trim($current) == "") {
    die("Não existe, nem devia existir, um aluno com um ID vazio.");
}

$alunos[$new] = $alunos[$current];
unset($alunos[$current]);

setAlunos($alunos);

redir("../alunos.php");

?>