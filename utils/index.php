<?php
$Sito= new Foreground;

?>
<!DOCTYPE html>
<html lang="<?php $Sito->lang();?>">
<head>
    <?php
    $Sito->title(SERVERNAME); //Title of the website
    $Sito->asset("bs/bootstrap.min.css"); //asset/js,css,media/path
    $Sito->asset("bs/bootstrap.min.js");
    $Sito->asset("jquery-3.6.0.js");
    ?>
</head>
<body>
    <div class="container text-center">
    <?php
    $Sito->element("element"); //Show an element (.php file) element/path
    ?>
    </div>
</body>
</html>
