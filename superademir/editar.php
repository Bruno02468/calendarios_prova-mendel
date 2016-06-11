<?php

include("../backend/sistema.php");

require_login("borginhos");

$nome = req_get("nome");


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
            <h1>Editando <?php echo $nome ?></h1>
            <br>
            <form method="POST" action="atuadores/edita.php">
                <input type="hidden" name="nome" value="<?php echo $nome; ?>">
                Nova senha: <input type="password" name="pass"><br>
                <br>
                <input class="buttonlink btnblue" type="submit" value="Salvar!">
            </form>
        </center>
    </body>
</html>