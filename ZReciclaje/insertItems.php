<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="insertItems.php" method="post">
        <label for="product">producto</label>
        <input type="text" id="product" name="product" required placeholder="Nombre del producto">
        <label for="id"></label>
        <input type="number" id="id" name="id" required placeholder="ID del producto">
        <label for="quantity"></label>
        <input type="number" id="quantity" name="quantity" required placeholder="Cantidad del producto">
        <label for="description"></label>
        <input type="text" id="description" name="description" placeholder="Descripción del producto (opcional)">

        <input type="submit" value="Enviar">
    </form>
</body>

</html>

<?php
//Recibe parametros, comprueba que se recibe el dato y proporciona desxcripción por defecto a description.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product"]) && isset($_POST["id"]) && isset($_POST["quantity"])) {
    $product = $_POST["product"];
    $id = $_POST["id"];
    $quantity = $_POST["quantity"];

    if (empty($_POST["description"])) {

        $description = "Descripcion no proporcionada";
    } else {
        $description = $_POST["description"];
    };


    insertItem($product, $id, $quantity, $description);
}

function insertItem($name, $id, $quantity, $description)
{
    $catalog = getCatalog();
    //$idExist = false;
    // foreach ($catalog->product as $product) {
    //     $idCatalog = (string)$product->id;

    //     if ($idCatalog == (string)$id) {
    //         $idExist = true;
    //         echo $idCatalog ."<br>";
    //     }
    // }

    // if ($idExist) {
    //     echo "el ID ya existe, elige otro id. <br>";
    //     echo "Último id escrito" . $idCatalog;
    // } else {

    // }

    $newProduct = $catalog->addChild("product");
    $newProduct->addChild("nombre", $name);
    $newProduct->addChild("id", $id);
    $newProduct->addChild("quantity", $quantity);
    $newProduct->addChild("description", $description);
    $catalog->asXML('../../xmldb/catalog.xml');
};
function getCatalog()
{

    $file = '../../xmldb/catalog.xml';

    if (file_exists($file)) {
        echo "Fichero encontrado";
        $catalog = simplexml_load_file($file);
    } else {
        echo "No se encontro el fichero";

        $catalog = new SimpleXMLElement('<catalog></catalog>');
    }
    return $catalog;
}

?>