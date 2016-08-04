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
            curta: " . var_export($materia["curta"], true) . ",
            selected: false\n
        });\n";
    }
}

$salas = "";
foreach (getSalas() as $sala) {
    $salas .= "<option value=\"$sala\">" . $sala[0] . "º " . $sala[1] . "</option>";
}

$err = "";
if (isset($_GET["err"])) $err = $_GET["err"];

?>
<html>
    <head>
        <title>Criar Calendário</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Criar um Calendário</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <a class="buttonlink btnorange" href="../votacao.php?guid=<?php echo $guid; ?>">Voltar à votação</a><br>
        <br>
        <br>
        Ninguém sugeriu um calendário de que você gostou?<br>
        Sem problema, crie o seu próprio!<br>
        <br>
        Mas antes, <b>vote em todos os calendários</b>, a sua opinião é vital!<br>
        <br>
        <form method="POST" action="atuadores/cria.php" onsubmit="return checar();">
            <div class="diamaker" id="dia1">
                <div>Dia <?php echo date("d/m", strtotime($votacao["dias"][0])); ?></div>
            </div>
            <br>
            <br>
            <div class="diamaker" id="dia2">
                <div>Dia <?php echo date("d/m", strtotime($votacao["dias"][1])); ?></div>
            </div>
            <br>
            <br>
            <div class="diamaker" id="dia3">
                <div>Dia <?php echo date("d/m", strtotime($votacao["dias"][2])); ?></div>
            </div>
            <br>
            <br>
            <div class="diamaker" id="dia4">
                <div>Dia <?php echo date("d/m", strtotime($votacao["dias"][3])); ?></div>
            </div>
            <br>
            <br>
            <br>
            Confirme seus dados de aluno:<br>
            <br>
            <table class="alunoform">
                <tr>
                    <td>Seu login do Moodle: </td>
                    <td><input type="number" name="alunid" id="moodle"></td>
                </tr>
                <tr>
                    <td>Sua sala: </td>
                    <td><select id="sala" name="sala"><?php echo $salas; ?></select></td>
                </tr>
                <tr>
                    <td>Seu número de chamada: </td>
                    <td><input id="chamada" name="chamada" type="number" min="1"></td>
                </tr>
                <tr>
                    <td>Seu primeiro nome: </td>
                    <td><input type="text" name="primeironome" id="nome"></td>
                </tr>
            </table>
            <br>
            <br>
            <input type="hidden" name="guid" value="<?php echo req_get("votid"); ?>">
            <div id="err"><?php echo $err; ?>&nbsp;</div>
            <input class="buttonlink bigbtn" type="submit" value="Enviar!">
        </form>
        <script>
            var materias = [];
            <?php echo $js; ?>
        </script>
        <script src="maker.js"></script>
    </body>
</html>