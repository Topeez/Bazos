<?php
function connDB(){

    $db_location ="127.0.0.1";
    $db_user ="root";
    $db_password ="";
    $db_name ="bazar";

    $conn = mysqli_connect($db_location,$db_user,$db_password, $db_name);

    if (mysqli_connect_error()){
        echo mysqli_connect_error();
        exit();
    }
    return $conn;
}

?>