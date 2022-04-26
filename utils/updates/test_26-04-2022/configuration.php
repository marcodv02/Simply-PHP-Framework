
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("HOST", "localhost");
define("USER", "marco");
define("PASSWORD", "36056");
define("DATABASE", "test");

define("SERVERNAME", "test");

if (session_status() === PHP_SESSION_NONE)
    session_start();

include_once "Controller/Server.php";