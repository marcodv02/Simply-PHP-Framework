<?php
include_once "connection.php";
$db_prodotti = "prodotti_dettaglio";
if (isset($_SESSION['session_id'])) {
  $accountText = $_SESSION['username'];
  $accountLink = "profile.php";
  if ($_SESSION['tipo'] == 1) {
    $db_prodotti = "prodotti_ingrosso";
  }
} else {
  $accountText = "Accedi/Registrati";
  $accountLink = "login.php";
}

include_once "class.Cart.php";

// Initialize Cart object
$cart = new Cart([
  // Can add unlimited number of item to cart
  'cartMaxItem'      => 0,

  // Set maximum quantity allowed per item to 99
  'itemMaxQuantity'  => 0,

  // Do not use cookie, cart data will lost when browser is closed
  'useCookie'        => false,
]);
/* $cart->destroy(); */
?>

<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Marea | <?php echo $title; ?> </title>
<meta name="description" content="<?php echo $content; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="marea, mareatavola, online store, filetti, pesce, ecommerce, palangari, tonno, sgombro, ricciola, pesce spada">
<!-- Favicon -->
<link rel="icon" href="../images/icona-pesci-marea.png" type="image/x-icon">
<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<!-- Fontawesome -->
<link rel="stylesheet" href="../css/fontawesome-free/css/all.min.css">

<!-- CSS 
    ========================= -->
<!-- Bootstrap 4.5 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


<!-- Plugins CSS -->
<link rel="stylesheet" href="assets/css/plugins.css">

<!-- Main Style CSS -->
<link rel="stylesheet" href="assets/scss/style.css<?php echo "?".time(); ?>">
<!-- Jquery autocomplete -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">


<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="68f98476-f7c1-4e5e-b16c-3ff0b25a66d0" data-blockingmode="auto" type="text/javascript"></script>
<script id="CookieDeclaration" src="https://consent.cookiebot.com/68f98476-f7c1-4e5e-b16c-3ff0b25a66d0/cd.js" type="text/javascript" async></script>

<style>
body {font-family: inherit; font-weight: normal !important;}
</style>