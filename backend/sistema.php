<?php
// Gerenciando mais um banco...

date_default_timezone_set("America/Sao_Paulo");

// Executa um redirecionamento relativo à URL atual.
function redir($relative) {
    $host  = $_SERVER["HTTP_HOST"];
    $uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$uri/$relative");
    die("Redirecionamento em progresso...");
}

// Exige uma variável GET 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_get($str) {
    if (!isset($_GET[$str])) {
        die("Variável GET \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_GET[$str];
    }
}

// Exige uma variável POST 100% esperada (e.g. de um form)
// e cancela a execução caso ela não esteja presente.
function req_post($str) {
    if (!isset($_POST[$str])) {
        die("Variável POST \"" . $str . "\" necessária para esta requisição.");
    } else {
        return $_POST[$str];
    }
}

function substituir_global($padrao, $subst, $texto) {
    while (preg_match($padrao, $texto))
        $texto = preg_replace($padrao, $subst, $texto);
    return $texto;
}

function currentDir() {
    return realpath(dirname(__FILE__)) . "/";
}

function make_guid() {
    mt_srand((double)microtime()*10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);
    $uuid =
         substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);
    return $uuid;
}

function getFullJSON($arq) {
    return json_decode(file_get_contents(currentDir() . $arq), true);
}

function setNewJSON($new_json, $arq) {
    file_put_contents(currentDir() . $arq, json_encode($new_json, JSON_HEX_TAG
    | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function getCredenciais() {
    return getFullJSON("credenciais.json");
}

function setCredenciais($novas) {
    setNewJSON($novas, "credenciais.json");
}

function userExists($nome) {
    $credenciais = getCredenciais();
    foreach ($credenciais as $credencial) {
        if ($credencial["nome"] == $nome) return true;
    }
    return false;
}

function getCredencial($nome) {
    $credenciais = getCredenciais();
    foreach ($credenciais as $credencial) {
        if ($credencial["nome"] === $nome) return $credencial;
    }
}

function addCredencial($nome, $pass) {
    $credenciais = getCredenciais();
    $salt = make_salt();
    $nova = array(
        "nome" => $nome,
        "opaque" => hash("sha512", "${pass}${salt}"),
        "salt" => $salt
    );
    array_push($credenciais, $nova);
    setCredenciais($credenciais);
}

function editCredencial($nome, $newpass) {
    $credenciais = getCredenciais();
    $newsalt = make_salt();
    foreach ($credenciais as $index => $credencial) {
        if ($credencial["nome"] === $nome) {
            $nova = array(
                "nome" => $nome,
                "opaque" => hash("sha512", "${newpass}${newsalt}"),
                "salt" => $newsalt
            );
            $credenciais[$index] = $nova;
        }
    }
    setCredenciais($credenciais);
}

function removeCredencial($nome) {
    $credenciais = getCredenciais();
    foreach ($credenciais as $index => $credencial) {
        if ($credencial["nome"] === $nome) unset($credenciais[$index]);
    }
    setCredenciais($credenciais);
}

// Checa se um login consta no banco de dados.
function isright($user, $pass) {
    if (!userExists($user)) return false;
    $credencial = getCredencial($user);
    $opaque = $credencial["opaque"];
    $salt = $credencial["salt"];
    $newopaque = hash("sha512", "${pass}${salt}");
    return $opaque === $newopaque;
}

// Insere o header de login na resposta do servidor.
function headauth($msg) {
    header("WWW-Authenticate: Basic realm=\"$msg\"");
    header("HTTP/1.0 401 Unauthorized");
    echo $msg;
    die("<br><br>Eu disse que tinha que fazer login...");
}

// Exige um certo login para a exibição da página.
// Se $wanted == "", aceita qualquer login menos "borginhos".
function require_login($wanted = "") {
    $username = null;
    $password = null;

    if (isset($_SERVER["PHP_AUTH_USER"])) {
        $username = $_SERVER["PHP_AUTH_USER"];
        $password = $_SERVER["PHP_AUTH_PW"];
    }

    if (is_null($username)) {
        headauth("Voce precisa fazer login para continuar!");
    } else {
        if (!userExists($username)) {
            headauth("Esse usuario nao existe!");
        }
        if ($username !== $wanted && $wanted != "")  {
            headauth("Esse login nao e o correto!");
        }
        if (!isright($username, $password)) {
            headauth("Senha incorreta!");
        }
    }
}

function getUser() {
    return $_SERVER["PHP_AUTH_USER"];
}

function getAlunos() {
    return getFullJSON(".htalunos.json");
}

function setAlunos($novos) {
    setNewJSON($novos, ".htalunos.json");
}

function setAluno($matricula, $assoc) {
    $json = getAlunos();
    $json[$matricula] = $assoc;
    setAlunos($json);
}

function unsetAluno($matricula) {
    $json = getAlunos();
    unset($json[$matricula]);
    setAlunos($json);
}

function alunoCorreto($primeiro_nome, $ano, $sala, $chamada, $moodle) {
    $alunos = getAlunos();
    if (isset($alunos[$moodle])) {
        $aluno = $alunos[$moodle];
        return tolower(explode(" ", $aluno["nome"])[0]) === tolower($primeiro_nome)
            and $aluno["ano"] == $ano
            and $aluno["sala"] == $sala
            and $aluno["chamada"] == $chamada;
    }
    return false;
}

function getMaterias() {
    return getFullJSON("materias.json");
}

function setMaterias($novas) {
    setNewJSON($novas, "materias.json");
}

function setMateria($nome, $assoc) {
    $json = getMaterias();
    $json[$nome] = $assoc;
    setMaterias($json);
}

function unsetMateria($nome) {
    $json = getMaterias();
    unset($json[$nome]);
    setMaterias($json);
}

function getVotacoes() {
    return getFullJSON("votacoes.json");
}

function setVotacoes($novas) {
    setNewJSON($novas, "votacoes.json");
}

function addVotacao($assoc) {
    $json = getVotacoes();
    $json[make_guid()] = $assoc;
    setVotacoes($json);
}

function getSalas() {
    return array(
        "1A", "1B", "1C", "1D", "1E", "1F", "1G", "1H", "1I",
        "2A", "2B", "2C", "2D", "2E", "2F", "2G", "2H",
        "3A", "3B", "3C", "3D", "3E", "3F", "3G"
    );
}