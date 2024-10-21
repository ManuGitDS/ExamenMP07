<?php
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
/*******SESION************/
echo '<fieldset>';
echo '<legend>Sesión</legend>'; // Título del recuadro
echo '<strong>' . htmlspecialchars($_SESSION['dni']) . '</strong><br>'; 
echo '<strong>' . htmlspecialchars($_SESSION['nombre']).'</strong><br>'; 
echo '</fieldset><br>';
/*******SESION ************/


///////////USER REGISTER/////////////////
function UserRegister($dni, $user, $password)
{
    $userExist = __getUserByDNI($dni);

    if ($userExist) {
        echo "El usuario ya existe";
    } else {
        $file = 'xmldb/users.xml';

        if (file_exists($file)) {
            $users = simplexml_load_file($file);
        } else {

            $users = new SimpleXMLElement('<users></users>');
        }


        $use = $users->addChild('user');
        $use->addChild('dni', $dni);
        $use->addChild('user', $user);
        $use->addChild('password', $password);

        $users->asXML('xmldb/users.xml');

        $userCart = __makeCartUser($dni);

        echo "Usuario registrado correctamente";

        if ($userCart) {
            echo "<br>Carrito user creado!";
        }
    }
};

function __makeCartUser($dni)
{
    $cart = new SimpleXMLElement('<cart> </cart>');
    $cart->asXML('xmldb/cart_' . $dni . '.xml');
    return $cart;


    // if (file_exists($file)) {
    //     echo "error";
    // } else {
    //     echo " funciona";
    // }
}


//////////////////////////////USER LOGIN/////////////////////////////////////
function login($dni, $password)
{
    //session_start();

    $userData = __getUser($dni, $password);


    $_SESSION['dni'] = $dni;
  

    if ($userData) {

        $_SESSION['nombre'] = (string)$userData[0]->user;


        echo "Bienvenido " . $_SESSION['nombre'];
    } else {
        echo "usuario o contraseña incorrecta";
    }
    
    /*echo "<pre>";
    print_r($userData);
    echo "<pre>";*/
}


function __getUser($dni, $password)
{
    $users = simplexml_load_file("xmldb/users.xml");
    if ($users === false) {
        echo "Error al cargar el archivo XML";
        return null;
    } else {
        $userData = $users->xpath("/users/user[dni='$dni' and password='$password']");
        return $userData;
    }
}

function __getUserByDNI($dni)
{
    $users = simplexml_load_file("xmldb/users.xml");

    if ($users === false) {
        echo "Error al cargar el archivo XML";
        return null;
    } else {
        $userData = $users->xpath("/users/user[dni='$dni']");
        return $userData;
    }
}
function closeSesion(){
    session_unset(); 
    session_destroy(); 
    echo "Has cerrado sesión."; 
}