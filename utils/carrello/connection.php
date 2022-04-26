<?php

if (session_status() == PHP_SESSION_NONE || session_id() == '') {
    session_start();
}

$NomeDB = "mareatavola";
if (gethostname() != "LAPTOP-9J5TVHQH" && gethostname() != "DESKTOP-AI9MEBA" && gethostname() != "loyckPC") {
    $IpServer = "localhost";
    $Utente = "mareatavola";
    $Password = "marea@2020";
} else {
    $IpServer = "localhost";
    $Utente = "root";
    $Password = "";
}
// ----------------------------------------------------------------------------
// Se il Web Server non � attivo, la procedura � interrotta
if (($db1 = new mysqli($IpServer, $Utente, $Password, $NomeDB))->connect_error) {
    echo ("non esiste");
}

unset($_SERVER['connection']);
?>