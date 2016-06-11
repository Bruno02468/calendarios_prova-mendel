<?php

include("../backend/sistema.php");

require_login("borginhos");

$credenciais = getCredenciais();

$editlinks = "";
foreach ($credenciais as $credencial) {
    $user = $credencial["nome"];
    $editlinks .= "<a class=\"buttonlink btnblue smallbtn\" href=\"editar.php?nome=$user\">$user</a>
     <a class=\"buttonlink btnred smallbtn\" href=\"atuadores/deleta.php?nome=$user\">deletar</a><br><br>";
}

?>

<html>
    <head>
        <title>Painel Superadministrativo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../backend/estilo.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>

    <body>
        <center>
            <h1>Painel Superadministrativo</h1>
            <br>
            <div class="big">
                <a class="buttonlink btnorange bigbtn" href="..">Página inicial</a><br>
                <br>
                <a class="buttonlink bigbtn" href="criar.php">Criar um login</a><br>
                <br>
                Editar um login:<br>
                <br>
                <?php echo $editlinks; ?>
            </div>
        </center>
    </body>
</html>