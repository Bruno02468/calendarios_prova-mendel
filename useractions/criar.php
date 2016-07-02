<?php

include("../backend/sistema.php");

$guid = req_get("votid");
$votacao = getVotacoes()[$guid];
$ano = $votacao["ano"];
$periodo = $votacao["periodo"];
$etapa = $votacao["etapa"];
$calendarios = $votacao["calendarios"];

$js = "";
foreach(getMaterias() as $nome => $materia) {
    if (in_array($ano, $materia["anos"])) {
        if ($nome == "Arte" and $etapa == 1) continue;
        $js .= "materias.push({
            nome: \"" . $nome . "\",
            natureza: \"" . $materia["natureza"] . "\",
            curta: " . var_export($materia["curta"], true) . "
        });\n";
    }
}



?>
<html>
    <head>
        <title>Criar calendário</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body style="text-align: center;">
        <h1>Criar um calendário</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <br>
        Ninguém sugeriu um calendário de que você gostou?<br>
        Sem problema, crie o seu próprio!<br>
        <br>
        <br>
        <br>
        <script>
            var materias = [];
            <?php echo $js; ?>
        </script>
    </body>
</html>