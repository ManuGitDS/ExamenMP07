<?php

function removeItem($itemID){
    
    if (_prodExist($itemID)){
        echo "El producto EXISTE -----> FUNCION removeItem<br>";
        _executeRemoveItem($itemID);
     }else{
        echo "El producto no existe";
     }

}

function _prodExist($itemID){

    $prodExist = false;
    $counter = 0;

    $cart = simplexml_load_file("xmldb/cart.xml");
    foreach($cart->product_item as $producto){
        if ($producto->id_product == $itemID) {
            $prodExist = true;
            $counter++;
            
        };
    }
    //echo "se encontraron ". $counter ."Productos";
    return $prodExist; 
}

function _executeRemoveItem($itemID){
    echo "------------------------------> FUNCION _executeRemoveItem <br>";
    $cart = simplexml_load_file("xmldb/cart.xml");
    

    foreach($cart->product_item as $producto){
        if ($producto->id_product == $itemID){
            echo "Dentro if <br>";
            unset($cart);
            
       
        }
    }




    
};

?>