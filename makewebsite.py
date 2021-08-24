import sys, os, shutil
from tree import *

dirs= ["asset", "view", "api", "Controller", "element"]
asset= ["css", "css/bs", "css/page_style", "css/page_style/admin"
        "js", "js/bs", "js/page_script", "js/page_script/admin"
        "media"]
website= input("Inserire il nome del sito\n>>>")

os.mkdir(website)

website+= "/"

for i in dirs:
    os.mkdir(website+i)

for i in dirs:
    os.mkdir(website+"asset/"+i)

configuration= """<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define(\"HOST\", \"{db_host}\");
define(\"USER\", \"{db_user}\");
define(\"PASSWORD\", \"{db_pw}\");
define(\"DATABASE\", \"{db_name}\");

define(\"SERVERNAME\", \"{server_name}\");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once \"Controller/Server.php\";
""".format(
        db_host= input("Inserire host db:\n>>>"),
        db_user= input("Inserire user db:\n>>>"),
        db_pw= input("Inserire password db:\n>>>"),
        db_name= input("Inserire nome db:\n>>>"),
        server_name= website[:-1]
    )

htaccess= """RewriteEngine On

RewriteRule admin/([^/]+)\.php?(.*)$ index.php?admin=$1 [QSA]
RewriteRule api/([^/]+)\.php?(.*)$ index.php?api=$1 [QSA]
RewriteRule page/([^/]+)\.php?(.*)$ index.php?page=$1 [QSA]
"""

index= """<?php
include_once "configuration.php";

$Sito= new Foreground;
$page= "index";

if (isset($_GET["page"]))
    $page= $_GET["page"];//.".php";
elseif (isset($_GET["admin"])){
elseif (isset($_GET["admin"])){
    if ($_GET["admin"]!="login"){
        if (!isset($_SESSION["UID"])){
            header("location:login.php");
        }
    }
    $page= "admin/".$_GET["admin"];
}elseif (isset($_GET["api"])){
    $page= "api/".$_GET["api"];
}
$Sito->view($page);
"""

f= open(website+"configuration.php", "w")

f.write(configuration)

f.close()

f= open(website+".htaccess", "w")

f.write(htaccess)

f.close()

f= open(website+"index.php", "w")

f.write(index)

f.close()

shutil.copy("utils/Controller/Server.php", website+"Controller/")
shutil.copy("utils/index.php", website+"view/")
shutil.copy("utils/element.php", website+"element/")
for i in os.listdir("utils/assets/bs/css"):
    shutil.copy("utils/assets/bs/css/"+i, website+"asset/css/bs/")
for i in os.listdir("utils/assets/bs/js"):
    shutil.copy("utils/assets/bs/js/"+i, website+"asset/js/bs/")
shutil.copy("utils/assets/jquery-3.6.0.js", website+"asset/js/")
website= website[:-1]
tree(website)
