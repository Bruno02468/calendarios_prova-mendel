<?php

include("../backend/sistema.php");

require_login();

$nome = req_get("nome");
$materia = getMaterias()[$nome];

?>

<html>
    <head>
        <title>Editando <?php echo $nome; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>

    <body>
        <center>
            <h1>Editando <?php echo $nome; ?></h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink btnorange bigbtn" href="./materias.php">Voltar</a><br>
                <br>
                <br>
                <form method="POST" action="atuadores/seta_materia.php">
                    Nome: <input type="text" name="nome" value="<?php echo $nome; ?>"><br>
                    Natureza:
                    <select name="natureza" value="<?php echo $materia["natureza"]; ?>">
                        <option value="e">Exatas</option>
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
                    <label><input type="checkbox" name="curta"<?php if ($materia["curta"]) echo " checked"; ?>> Prova curta (metade do valor)</label><br>
                    <input class="buttonlink btnblue" type="submit" value="Salvar">
                </form>
            </div>
        </center>
    </body>
</html>