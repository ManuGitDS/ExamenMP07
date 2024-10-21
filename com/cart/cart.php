
<?php
include_once("com/catalog/catalog.php");
//////estilos para la sesion activa
echo '<style>
fieldset {
    display: inline-block; 
    border: 2px solid #007BFF; 
    border-radius: 5px; 
    padding: 10px; 
    margin: 15px 0; 
}

legend {
    font-weight: bold; 
    color: #007BFF; 
}
</style>';
//////////////////////////////
session_start();

function AddToCart($id_product, $quantity)
{
    //session_start();
    $userCart = $_SESSION['dni'];
    $cart = GetCart($userCart);
    $itemExist = __itemExist($id_product);

    if ($itemExist) {
        echo "existe";
        if (__quantityEnough($quantity,$id_product)) {
            echo "<br>Hay suficiente cantidad";
            $price = __getPrice($id_product);
            $currency = __getCurrency($id_product);

            $item = $cart->addChild('product_item');
            $item->addChild('id_product', $id_product);
            $item->addChild('quantity', $quantity);
            $item_price = $item->addChild("price_item");
            $item_price->addChild('price', $price);
            $item_price->addChild('Currency', $currency);

            $cart->asXML('xmldb/cart_' . $userCart . '.xml');


            echo "<br>Producto añadico correctamente";
        } else {
            echo "<br>No hay suficiente cantidad";
        }
    } else {
        echo "<br>El producto no existe";
    }

}


function GetCart($userCart)
{

    $file = 'xmldb/cart_' . $userCart . '.xml';

    if (file_exists($file)) {
        $cart = simplexml_load_file($file);
    } else {

        $cart = new SimpleXMLElement('<cart> </cart>');
    }

    return $cart;
};
/////////////Existe el item?////////////////////
function removeFromCart($itemID)
{
    $prodExiste = _prodExist($itemID);

    if ($prodExiste) {
        _executeRemoveItem($itemID);
    } else {
        echo "El producto no existe";
    }
}
/////////////Existe el item 2?////////////////////
function _prodExist($itemID)
{

    $cartUser = $_SESSION['dni'];
    $prodExist = false;
    $counter = 0;

    $cart = simplexml_load_file("xmldb/cart_" . $cartUser . ".xml");
    foreach ($cart->product_item as $producto) {
        if ($producto->id_product == $itemID) {
            $prodExist = true;
            $counter++;
        };
    }
    //echo "se encontraron ". $counter ."Productos";
    return $prodExist;
}
/////////////Eliminar Item////////////////////
function _executeRemoveItem($itemID)
{
    $cartUser = $_SESSION['dni'];
    // Cargar el XML usando simplexml_load_file
    $cart = simplexml_load_file("xmldb/cart_" . $cartUser . ".xml");

    // Crear un índice para el control
    $index = 0;
    $found = false;

    // Recorrer el carrito de compras
    foreach ($cart->product_item as $producto) {
        // echo "id" .$producto->id_producto."<br>";
        //echo "Cantidad = " .$producto->quantity . "<br>";
        if ((string)$producto->id_product == (string)$itemID) {
            echo "Producto encontrado <br>";

            // Eliminar el producto usando el índice del nodo
            unset($cart->product_item[$index]);
            $found = true;
            break;
        }
        $index++;
    }
    // Si se encuentra y eliina el nodo, guarda el archivo XML
    if ($found) {
        $cart->asXML("xmldb/cart_" . $cartUser . ".xml");
        echo "Producto eliminado y archivo guardado.<br>";
    } else {
        echo "Producto no encontrado.<br>";
    }
}

///////viewCart////////
function viewCart($descuento)
{
    //session_start();
    $userCart = $_SESSION['dni'];
    $cart = GetCart($userCart);
    $contador = 1;
    $maxProducts = 0;
    $totalPorProducto = 0;
    $total = 0;


    echo "DETALLES DEL PRODUCTO <br><br>";
    foreach ($cart->product_item as $product) {
        echo "<u><b>PRODUCTO Nº " . $contador . "</b></u><br>";
        echo "<b>ID :</b>" . $product->id_product . "<br>";
        echo "<b>Cantidad :</b> " . $product->quantity . "<br>";


        $prices = $product->price_item;
        echo "<b>Precio </b>" . $prices->price . "<br>";
        echo "<b>Moneda </b>" . $prices->Currency . "<br><br><br>";

        $totalPorProducto = $product->quantity * $prices->price;

        $maxProducts += $product->quantity;
        $total += $totalPorProducto;
        $contador++;
    }

    $discount = $total * $descuento / 100;

    echo "<strong>TOTAL DE PRODUCTOS: " . $maxProducts . "</strong><br><br>";
    echo "<strong>COSTE TOTAL: " . $total . " USD</strong> <br>";
    echo "<strong>COSTE TOTAL CON EL " . $descuento . "% APLICADO " . $total - $discount . " USD</strong>";
};

//////UPDATE CART///////
function updateCart($id_item, $quiantity)
{
    //session_start();
    $userCart = $_SESSION['dni'];
    $name = $_SESSION['nombre'];
    $cart = GetCart($userCart);

    if (count($cart->product_item) > 0) {

        //echo "El carrito tiene productos.";

        foreach ($cart->product_item as $product) {
            $item = $product->id_product;
            //$quanity = $product->quantity;
            if ($item == $id_item) {
                $product->quantity = $quiantity;
            }
        }
        $cart->asXML('xmldb/cart_' . $userCart . '.xml');
        echo "<br>Carrito actualizado correctamente<br> ID " . $id_item . " Cantidad atualizada <br> Unidades actuales " . $quiantity;
    } else {
        echo "El carrito está vacio.";
    }
}
?>