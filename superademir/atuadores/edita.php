<?php

include("../../backend/sistema.php");

require_login("borginhos");

editCredencial(req_post("nome"), req_post("pass"));

redir("..");

?>