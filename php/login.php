<?php

session_start();
include_once "functions.php";

$error = [];
$error['email_empty'] = false;
$error['pass_empty'] = false;
$error['pass_correct'] = true;

$execute = true;
if($_SESSION['logged'] == false && isset($_POST['email'], $_POST['pass'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    
    //validate
    if($email === ""){
        $error['email_empty'] = true;
        $execute = false;
    }
    if($pass === ""){
        $error['pass_empty'] = true;
        $execute = false;
    }
    if($execute){
        if(passCorrect($email, $pass)){   
            $_SESSION['logged'] = true;
        }
        else{
            $error['pass_correct'] = false;
        }
    }
    
}


header('Content-Type: application/json');
echo json_encode($error);


?>
