<?php

include("../backend/sistema.php");

require_login();

$materias = getMaterias();
$editlinks = "";
foreach ($materias as $nome => $assoc) {
    $editlinks .= "<a class=\"buttonlink btnblue smallbtn\"
        href=\"editar_materia.php?nome=" . urlencode($nome) . "\">$nome</a><br>";
}

?>
<html>
    <head>
        <title>Gerenciando matérias</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <center>
            <h1>Gerenciando matérias</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href=".">Voltar</a><br>
                <br>
                <br>
                Adicionar matéria:<br>
                <br>
                <form method="POST" action="atuadores/seta_materia.php">
                    Nome: <input type="text" name="nome"><br>
                    Natureza:
                    <select name="natureza">
                        <option value="e" selected="selected">Exatas</option>
                        <option value="h">Humanas</option>
                        <option value="b">Biológicas</option>
                        <option value="i">Inglês</option>
                    </select>
                    <br>
                    <br>
                    <label><input type="checkbox" name="ano1"> Primeiro ano</label><br>
                    <label><input type="checkbox" name="ano2"> Segundo ano</label><br>
                    <label><input type="checkbox" name="ano3"> Terceiro ano</label><br>
                    <br>
                    <label><input type="checkbox" name="curta"> Prova curta (metade do valor)</label><br>
                    <br>
                    <input class="buttonlink btnblue" type="submit" value="Salvar">
                </form>
                Editar matérias:<br>
                <br>
                <?php echo $editlinks; ?>
            </div>
        </center>
    </body>
</html>