<?php



//////////////////////////////
function AddToCart($id_product, $quantity,$price,$country)
{
    

    $cart = GetCart();

    $item = $cart->addChild('product_item');
    $item->addChild('id_product', $id_product);
    $item->addChild('quantity', $quantity);

    $item_price = $item->addChild("price_item");
    $item_price->addChild('price',$price);
    $item_price->addChild('Currency',$country);

    $cart->asXML('xmldb/cart.xml');
}
/////////////////////////////
function GetCart()
{
    $file = 'xmldb/cart.xml';

    if (file_exists($file)) {
        $cart = simplexml_load_file($file);
        

    } else {

        $cart = new SimpleXMLElement('<cart></cart>');
        
    }

    return $cart;
};
/////////////////////////////
