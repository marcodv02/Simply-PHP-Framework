<?php
include_once "configuration.php";

$Sito= new Foreground;

if (isset($_GET["admin"])or(isset($_GET["api"])))
    unset($_GET["page"]);


if (isset($_GET["page"]))
    $Sito->view($_GET["page"]);
elseif (isset($_GET["admin"])){
    if ($_GET["admin"]!="login"){
        if (!isset($_SESSION["UID"])){
            header("location:login.php");
        }
    }
    $page= "admin/".$_GET["admin"];
    $Sito->view($page);
}elseif (isset($_GET["api"])){
    $Sito->api($_GET["api"]);
}elseif (isset($_GET["element"])){
    $Sito->element($_GET["element"]);
}else
    $Sito->view("index");