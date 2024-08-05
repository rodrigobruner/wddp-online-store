<?php

Class DB{
    public static function getConection(){
        $servername = 'localhost';  //'127.0.0.1'; // our server is local
        $username = 'root';         // db userna
        $password = 'root';             // db password
        $dbname = 'kermet_store';   // DB name

        return new mysqli($servername, $username, $password, $dbname);
    }
}

try{
    // create a connection
    $db = DB::getConection();

    // check for errors
    if($db->connect_error) {
        die('Something is not working. Please come back later....');
    }
} catch (Exception $e) {
    include "app/pages/system/dbError.php";
    die;
}