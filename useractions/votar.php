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
    if ($sala[0] != $ano) continue;
    $salas .= "<option value=\"$sala\">" . $sala[0] . "º " . $sala[1] . "</option>";
}

$err = "";
if (isset($_GET["err"])) $err = $_GET["err"];

?>
<html>
    <head>
        <title>Confirmar dados</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    </head>
    <body style="text-align: center;">
        <h1>Confirme seus dados!</h1>
        <small>
            Programado e idealizado por <a href="//licoes.com/licao/contato.html">
            Bruno Borges Paschoalinoto</a> (ou Borginhos)
        </small>
        <br>
        <br>
        <form method="POST" action="atuadores/vota.php" onsubmit="salvar()" id="form">
            <br>Você está prestes a escolher um calendário como o merecedor do seu voto.<br>
            <br>Seu voto conta tanto quanto o de qualquer outro aluno da escola.<br>
            <br>Após votar, você não pode "anular" seu voto, pode apenas mudá-lo votando em outro.<br>
            <br>
            <br><b>Se estiver certo da escolha, confirme seus dados de aluno:</b><br>
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
                    <td>Primeira parte do seu nome: </td>
                    <td><input type="text" name="primeironome" id="nome"></td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="guid" value="<?php echo req_get("votid"); ?>">
            <input type="hidden" name="autor" value="<?php echo req_get("autor"); ?>">
            <div id="err"><?php echo $err; ?>&nbsp;</div>
            <input class="buttonlink bigbtn" type="submit" value="Votar!">
        </form>
        <script>
            if (window.localStorage) {
                var c = 0;
                if (localStorage["sala"]) {
                    document.getElementById("sala").value = localStorage["sala"];
                }
                if (localStorage["numero"]) {
                    document.getElementById("chamada").value = localStorage["numero"];
                }
                if (localStorage["moodle"]) {
                    document.getElementById("moodle").value = localStorage["moodle"];
                }
                if (localStorage["primeironome"]) {
                    document.getElementById("nome").value = localStorage["primeironome"];
                }
            }
            function salvar() {
                if (window.localStorage) {
                    localStorage["sala"] = document.getElementById("sala").value;
                    localStorage["numero"] = document.getElementById("chamada").value;
                    localStorage["moodle"] = document.getElementById("moodle").value;
                    localStorage["primeironome"] = document.getElementById("nome").value;
                }
            }
        </script>
    </body>
</html>