<?php
/*header('Access-Control-Allow-Origin: *');*/
session_start();
include_once "functions.php";

$error = [];
$error['name_empty'] = false;
$error['email_empty'] = false;
$error['phone_empty'] = false;
$error['pass_empty'] = false;
$error['pass1_empty'] = false;
$error['rules_empty'] = false;

$error['email_used'] = false;
$error['phone_used'] = false;
$error['pass_match'] = true;
$error['pass_correct'] = true;

$execute = true;

if($_SESSION['logged'] == false && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['pass'], $_POST['pass_again'])){
    $add_time = date('Y-m-d H:i:s');
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $pass_again = $_POST['pass_again'];
    //validate
    if($name === ""){
        $error['name_empty'] = true; 
        $execute = false;
    }
    if($email === ""){
        $error['email_empty'] = true;
        $execute = false;
    }
    if($phone === ""){
        $error['phone_empty'] = true; 
        $execute = false;
    }
    if($pass === ""){
        $error['pass_empty'] = true;
        $execute = false;
    }
    if($pass_again === ""){
        $error['pass1_empty'] = true; 
        $execute = false;
    }
    if(!isset($_POST['rules'])){
        $error['rules_empty'] = true;
        $execute = false;
    }
    if(isEmailUsed($email)){
        $error['email_used'] = true; 
        $execute = false;
    }
    if(isPhoneUsed($phone)){
        $error['phone_used'] = true; 
        $execute = false;
    }
    if(!($pass === $pass_again)){
        $error['pass_match'] = false;
        $execute = false;
    }
    if(strlen($pass) < $pass_min || strlen($pass) > $pass_max){
        $error['pass_correct'] = false;
        $execute = false;
    }
    $payment = "";
    if(isset($_POST['payment'])){
        $payment = $_POST['payment'];
    }
    $range = "";
    if(isset($_POST['range'])){
        $range = $_POST['range'];
    }
    $nip = "";
    if(isset($_POST['nip'])){
        $nip = $_POST['nip'];
    }
    $company = "";
    if(isset($_POST['company_name'])){
        $company = $_POST['company_name'];
    }
    
    //validate end
    if($execute){
        registerUser($name, $add_time, $email, $phone, $pass, $payment, $range, $nip, $company);
    }
    
    
    header('Content-Type: application/json');
    echo json_encode($error);
}

?>
