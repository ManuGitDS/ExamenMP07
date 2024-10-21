<?php

echo "<br>INIT EXECUTION" . "<br><br>";
include_once("com/cart/cart.php");
include_once("com/users/users.php");
// 
//UserRegister(53310,'Manuel');
// removeItem(4);
//http://localhost:40080/ExamenMP07_2.0/main.php?funcion=hola&otro=holaotravez
$function = $_GET['function'];

switch ($function) {
        
    case 'userregister': //http://localhost:40080/ExamenMP07_2.0/main.php?function=userregister&dni=46793204A&name=Manuel&password=1234
        $dni = $_GET['dni'];
        $nombre = $_GET['name'];
        $password = $_GET['password'];
        UserRegister($dni, $nombre,$password);
        break;
    case 'login': // http://localhost:40080/ExamenMP07_2.0/main.php?function=login&dni=46793204A&password=1234
        $dni = $_GET['dni'];
        $password = $_GET['password'];
        login($dni,$password);
        break;
    case 'addtocart': //http://localhost:40080/ExamenMP07_2.0/main.php?function=addtocart&id=5&quanity=3
        $id_product = $_GET['id'];
        $quanity = $_GET['quanity'];
        //$price = $_GET['price'];
        //$currency = $_GET['currency'];
        AddToCart($id_product, $quanity);
        break;
    case 'removefromcart': //http://localhost:40080/ExamenMP07_2.0/main.php?function=removefromcart&id=2
        $itemID = $_GET['id'];
        removeFromCart($itemID);
        break;
    case 'viewcart': // http://localhost:40080/ExamenMP07_2.0/main.php?function=viewcart&discount=20
        $discount = $_GET['discount'];
        viewCart($discount);
        break;
     
    case 'updatecart': // http://localhost:40080/ExamenMP07_2.0/main.php?function=updatecart&itemid=20&quantity=1
        $update = $_GET['itemid'];
        $quiantity = $_GET['quantity'];
        updateCart($update, $quiantity);
        break;
    case 'closesesion':
        closeSesion();
        break;
}
