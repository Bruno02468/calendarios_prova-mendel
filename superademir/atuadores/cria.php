<?php

include("../../backend/sistema.php");

require_login("borginhos");

addCredencial(req_post("nome"), req_post("pass"));

redir("..");

?>