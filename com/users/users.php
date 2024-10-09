<?php
function UserRegister($dni,$user){

    $file = 'xmldb/users.xml';

    if (file_exists($file)) {
        $users = simplexml_load_file($file);
     

    } else {

        $users = new SimpleXMLElement('<users></users>');
        
    }

    $use = $users->addChild('user');
    $use->addChild('DNI', $dni);
    $use->addChild('user', $user);

  

    $users->asXML('xmldb/users.xml');


};


?>