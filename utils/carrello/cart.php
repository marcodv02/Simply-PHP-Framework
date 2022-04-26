<?php include_once "connection.php";
$title = "Carrello";
$content = "Pagina carrello";
if (isset($_SESSION['codiceCoupon']) && $_SESSION['codiceCoupon'] != '' && isset($_SESSION['scontoCoupon']) && $_SESSION['scontoCoupon'] != '') {
    $cp = true;
} else {
    $cp = false;
}
?>
<!DOCTYPE html>
<html lang="it" class="no-js scheme_default">

<head>
    <?php include_once "_top.php"; ?>
</head>

<body>

    <?php include_once "header.php"; ?>

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#">Carrello</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    <!--shopping cart area start -->
    <div class="shopping_cart_area mt-60">
        <div class="container" id="cartTable">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div id="carp" class="cart_page table-responsive" style="max-height: 40rem; overflow: scroll;">
                                <table>
                                    <thead <?php if ($cart->isEmpty()) echo "hidden"; ?>>
                                        <tr>
                                            <th class="product_remove">Elimina</th>
                                            <th class="product_thumb">Anteprima</th>
                                            <th class="product_name">Nome prodotto</th>
                                            <th class="product-price">Prezzo</th>
                                            <th class="product_quantity">Quantità</th>
                                            <th class="product_total">Totale</th>
                                            <?php
                                            if (isset($_SESSION['session_id']) && $_SESSION['session_id'] != '' && isset($_SESSION['tipo']) && $_SESSION['tipo']) {
                                                echo '<th class="product_total">Totale + IVA</th>';
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        function get_sconto($id, $attributo){
                                            global $cart;
                                            if (isset($_SESSION['scontoCoupon'])){
                                                if (in_array(intval($id), $_SESSION['prodotti_scontati']))
                                                    return "<h3 style='color:red'>-".number_format($cart->sconto_item($id, $_SESSION['scontoCoupon'], $attributo), 2, ',', '')."</h3>";
                                            }
                                            return "";
                                        }
                                        

                                        if ($cart->isEmpty()) {
                                            echo "<h2 style='padding:16px;text-align:center'>Nessun prodotto aggiunto al carrello, inizia a fare <a href='./'><u>shopping</u></a></h2>";
                                        } else {
                                            $allItems = $cart->getItems();
                                            $count = 0;
                                            foreach ($allItems as $items) {
                                                foreach ($items as $item) {
                                                    echo "<tr>";
                                                    if (isset($_SESSION['session_id']) && $_SESSION['session_id'] != '' && isset($_SESSION['tipo']) && $_SESSION['tipo']) {
                                                        echo '<td class="product_remove"><a class="removeItem btn" data-id="' . $item['id'] . '"><i class="fa fa-trash-o"></i></a></td>' .
                                                            '<td class="product_thumb"><a href="#"><img src="' . $item['attributes']['img'] . '" alt=""></a></td>' .
                                                            '<td class="product_name"><a href="' . $item['attributes']['link'] . '">' . $item['attributes']['name'] . '</a></td>' .
                                                            '<td class="product-price">&euro; ' . number_format($item['attributes']['price_az'] , 2, ',', ''). '</td>' .
                                                            '<td class="product_quantity"><div class="number-input"><span class="btn minus" 
                                                            onclick="this.parentNode.querySelector(\'#inputQty' . $count . '\').stepDown();
                                                            $(\'#inputQty' . $count . '\').change();"></span>
                                                            <input readonly id="inputQty' . $count . '" max="999" style="border:none !important;margin-left:unset !important;min-width: 5rem;" 
                                                            class="cartQty" data-id="' . $item['id'] . '" min="' . $item['attributes']['min_az'] . '" 
                                                            step="' . $item['attributes']['m'] . '" value="' . $item['quantity'] . '" type="number">
                                                            <span class="btn plus" onclick="this.parentNode.querySelector(\'#inputQty' . $count . '\').stepUp();
                                                            $(\'#inputQty' . $count . '\').change();"></span></div></td>' .
                                                            '<td class="product_total">&euro; ' . number_format($item['attributes']['price_az'] * $item['quantity'], 2, ',', ''). '</td>';
                                                        echo '<td class="product_total">&euro; ' . number_format($item['attributes']['price_az_iva'] * $item['quantity'], 2, ',', '').get_sconto($item['id'], 'price_az_iva').'</td>';
                                                    } else {
                                                        echo '<td class="product_remove"><a class="removeItem btn" data-id="' . $item['id'] . '"><i class="fa fa-trash-o"></i></a></td>' .
                                                            '<td class="product_thumb"><a href="#"><img src="' . $item['attributes']['img'] . '" alt=""></a></td>' .
                                                            '<td class="product_name"><a href="' . $item['attributes']['link'] . '">' . $item['attributes']['name'] . '</a></td>' .
                                                            '<td class="product-price">&euro; ' . number_format($item['attributes']['price_iva'], 2, ',', ''). '</td>' .
                                                            '<td class="product_quantity"><div class="number-input"><span class="btn minus" 
                                                            onclick="this.parentNode.querySelector(\'#inputQty' . $count . '\').stepDown();
                                                            $(\'#inputQty' . $count . '\').change();"></span>
                                                            <input readonly id="inputQty' . $count . '" max="999" style="border:none !important;margin-left:unset !important;min-width: 5rem;" 
                                                            class="cartQty" data-id="' . $item['id'] . '" min="' . $item['attributes']['min'] . '" 
                                                            step="' . $item['attributes']['m'] . '" value="' . $item['quantity'] . '" type="number">
                                                            <span class="btn plus" onclick="this.parentNode.querySelector(\'#inputQty' . $count . '\').stepUp();
                                                            $(\'#inputQty' . $count . '\').change();"></span></div></td>' .
                                                            '<td class="product_total">&euro; ' . number_format($item['attributes']['price_iva'] * $item['quantity'], 2, ',', '').get_sconto($item['id'], 'price_iva'). '</td>';
                                                    }
                                                    $count++;
                                                }
                                            }
                                        }



                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area start-->
                <div class="coupon_area" <?php if ($cart->isEmpty()) echo "hidden"; ?>>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left">
                                <h3>Coupon</h3>
                                <div class="coupon_inner">
                                    <p>Inserisci qui il codice del tuo coupon.</p>
                                    <div class="row align-items-center justify-content-center">
                                        <?php
                                        if (!$cp) {
                                        ?>
                                            <input id="couponCode" style='text-transform: uppercase' class="col-12 col-lg-6 mx-auto" placeholder="Coupon" type="text">
                                            <button id="couponButton" class="col-12 col-lg-4 mt-xs-3 mt-lg-0 mx-auto" onclick="checkCoupon($('#couponCode').val())">Usa coupon</button>
                                            <div style='display: none' class=' btn btn-dark col-12 col-lg-4 mt-xs-3 mt-lg-0 mx-auto' id="modifica">Modifica</div>
                                        <?php
                                        } else {
                                        ?>
                                            <input value="<?php echo $_SESSION['codiceCoupon'] ?>" disabled style='background: #ccc' id="couponCode" style='text-transform: uppercase' class="col-12 col-lg-6 mx-auto" placeholder="Coupon" type="text">
                                            <button style='display: none' id="couponButton" class="col-12 col-lg-4 mt-xs-3 mt-lg-0 mx-auto" onclick="checkCoupon($('#couponCode').val())">Usa coupon</button>
                                            <div style='display: block' class=' btn btn-dark col-12 col-lg-4 mt-xs-3 mt-lg-0 mx-auto' id="modifica">Modifica</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code right">
                                <h3>Riepilogo</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal" id="gTot">
                                        <p>Subtotale</p>
                                        <?php
                                        if (isset($_SESSION['session_id']) && $_SESSION['session_id'] != '' && isset($_SESSION['tipo']) && $_SESSION['tipo']) {
                                            echo "<p class=\"cart_amount\" id=\"subT\">" . '&euro;' . number_format($cart->getAttributeTotal('price_az'), 2, ',', '') . "</p>";
                                        } else {
                                            echo "<p class=\"cart_amount\" id=\"subT\">" . '&euro;' . number_format($cart->getAttributeTotal('price_iva'), 2, ',', '') . "</p>";
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if ($cp) {
                                        echo "<div class='cart_subtotal'><p>Coupon: ".$_SESSION['codiceCoupon']."</p><p class='cart_amount'> -" . $_SESSION['scontoCoupon'] ."%</p></div>";
                                    }
                                    ?>
                                    <div class="cart_subtotal ">
                                        <p>Spedizione</p>
                                        <p class="cart_amount">Vai al checkout per calcolare</p>
                                    </div>

                                    <div class="cart_subtotal">
                                        <?php
                                        if (isset($_SESSION['session_id']) && $_SESSION['session_id'] != '' && isset($_SESSION['tipo']) && $_SESSION['tipo']) {
                                            echo "<p>Totale+IVA</p>";
                                        } else {
                                            echo "<p>Totale</p>";
                                        }
                                        ?>
                                        <p class="cart_amount" id="fTot">
                                            <?php
                                            if (isset($_SESSION['session_id']) && $_SESSION['session_id'] != '' && isset($_SESSION['tipo']) && $_SESSION['tipo']) {
                                                if ($cp) {
                                                    echo "&euro;" . number_format(($cart->getAttributeTotal('price_az_iva') - $cart->get_sconted_val($_SESSION['prodotti_scontati'], floatval($_SESSION['scontoCoupon']), 'price_az_iva')), 2, ',', '');
                                                } else {
                                                    echo "&euro;" . number_format(($cart->getAttributeTotal('price_az_iva')), 2, ",", "");
                                                }
                                            } else {
                                                if ($cp) {
                                                    echo "&euro;" . number_format(($cart->getAttributeTotal('price_iva') - $cart->get_sconted_val($_SESSION['prodotti_scontati'], floatval($_SESSION['scontoCoupon']),'price_iva')), 2, ',', '');
                                                } else {
                                                    echo "&euro;" . number_format(($cart->getAttributeTotal('price_iva')), 2, ",", "");
                                                }
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="checkout_btn">
                                        <a href="checkout.php" class="mx-auto btn btn-block">Vai al Checkout</a>
                                    </div>
                                    <a href="index.php" style="background: #003057; color:#fff" class="mx-auto btn btn-block mt-2">Torna ai prodotti</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->
        </div>
    </div>
    <!--shopping cart area end -->


    <?php include_once "footer.php"; ?>


    <?php include_once "_bottom.php";
    $db1->close(); ?>

    <script>
        function checkCoupon(code) {
            if (code != '') {
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {
                        "codice": code
                    },
                    success: function(dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            var after_apply = dataResult.tot - dataResult.sconto;
                            $("<div class='cart_subtotal'><p>Coupon: "+dataResult.code+"</p><p class='cart_amount'> -" + (dataResult.value) + "%</p></div>").insertAfter("#gTot");
                            $("#fTot").html("&euro;" + after_apply.toFixed(2));
                            $("#couponButton").hide();
                            $("#couponCode").prop("disabled", true);
                            $("#couponCode").css("background", "#ccc");
                            $("#modifica").show();
                            alert("Codice applicato!");
                            location.reload();

                        } else if (dataResult.statusCode == 201) {
                            alert("Codice non valido!");
                        }
                    }
                });
            } else {
                alert("Inserisci un codice.");
            }
        }

        $(document).ready(function() {
            $(document).on("click", "#modifica", function() {
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {
                        "codice": -1
                    }
                })
                location.reload();
            });
        })
    </script>
</body>

</html>