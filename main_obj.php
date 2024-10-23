<?php

include_once("com/cart/clsCart.php");
include_once("com/catalog/clsCatalog.php");




$mycart = new clsCart();
//$mycart->show();
//$mycart->Analyse();
$mycart->add(10,'pr');

$catalog = new clsCatalog();
//$catalog->show();





?>