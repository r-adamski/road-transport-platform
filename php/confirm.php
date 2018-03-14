<?php
include_once "functions.php";

if(isset($_GET['token'])){
    $token = $_GET['token'];
    if(isEmailConfirmed($token)){
        echo "Email jest juz potwierdzony";
    }
    else{
        setEmailConfirmed($token);
        echo "Email potwierdzony!";
        header("http://localhost/mtrans/index.php");
    }
}
else{
    echo "Brak tokenu";
}

?>