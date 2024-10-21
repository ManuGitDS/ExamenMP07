<?php
function getCatalog()
{
    $file = 'xmldb/catalog.xml';

    if (file_exists($file)) {
        $catalog = simplexml_load_file($file);
    } else {

        $catalog = "Catalogo vacío";
    }

    return $catalog;
};

function GetItemCatalog($id_product)
{
    $itemCatalog = getCatalog();

    foreach ($itemCatalog->product_item as $item) {
        $itemId = $item->id_product;
        if ($itemId == $id_product) {
            $itemFound = $item;

            break;
        }
    }
    return $itemFound;
}



function __itemExist($id_product)
{
    $item = GetItemCatalog($id_product);
    $productoExiste = false;
    if (!is_null($item)) {
        $productoExiste = true;
    }
    return $productoExiste;
};

function __quantityEnough($quantity, $id_product)
{
    $isEnouch = false;
    $quantityEnouch = GetItemCatalog($id_product);
    if ($quantityEnouch->quantity >= $quantity) {
        $isEnouch = true;
    }
    return $isEnouch;
}


function __getPrice($id_product)
{
    $item = GetItemCatalog($id_product);
    $itemPrice = $item->price_item->price;
    // echo "<pre>";
    // echo var_dump($itemPrice);
    // echo "<pre>";
    return $itemPrice;
};

function __getCurrency($id_product)
{
    $item = GetItemCatalog($id_product);
    $itemCurrency = $item->price_item->Currency;
     echo "<pre>";
     echo var_dump($itemCurrency);
     echo "<pre>";

    return $itemCurrency;
}


















































// function __itemExist($id_product)
// {
//     $productoExiste = false;
//     $it=GetItemCatalog($itemId);
//     if (isset($it)){
//         $productoExiste = true;
//        }else{
//         $productoExiste="el producto no existe";
//        }
//     return $productoExiste;
// };

// function __getPrice($id_product)
// {
//     $it=GetItemCatalog($itemId );
//     $itemPrice = $it->product_item->price_item->price;

//     return $itemPrice;
// };
