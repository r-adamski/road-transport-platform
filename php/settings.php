<?php
session_start();
include_once "functions.php";

$error = [];
$error['email_used'] = false;
$error['phone_used'] = false;
$error['nip_used'] = false;
$error['pass_match'] = true;
$error['pass_correct'] = true;

if($_SESSION['logged'] && isset($_POST['name'], $_POST['email'],  $_POST['tel'], $_POST['new_pass'], $_POST['new_pass_repeat'], $_POST['payments'], $_POST['range'], $_POST['nip'], $_POST['company'])){
//name
if(!($_POST['name'] === '')){
    setUsersSql($_SESSION['id'], $_POST['name'], 'Name');
}
//email
if(!($_POST['email'] === '')){
    $email = $_POST['email'];
    if(!isEmailUsed($email)){
        setEmail($_SESSION['id'], $email);
    }
    else{
        $error['email_used'] = true;
    }
}
//phone
if(!($_POST['tel'] === "")){
    $tel = $_POST['tel'];
    if(!isPhoneUsed($tel)){
        setUsersSql($_SESSION['id'], $tel, 'Tel');
    }
    else{
        $error['phone_used'] = true;
    }
}
//pass
if(!($_POST['new_pass'] === '')){
    $pass1 = $_POST['new_pass'];
    $pass2 = $_POST['new_pass_repeat'];
    if($pass1 === $pass2){
        if(strlen($pass1) < $pass_min || strlen($pass1) > $pass_max){
            $error['pass_correct'] = false;
        }
        else{
            setPass($_SESSION['id'], $pass1);
        }
    }
    else{
        $error['pass_match'] = false;
    }
}
//payments
if(!($_POST['payments'] === '')){
    $payments = $_POST['payments'];
    setUsersSql($_SESSION['id'], $payments, 'Payment_methods');
}
//scope
if(!($_POST['range'] === '')){
    $scope = $_POST['range'];
    setUsersSql($_SESSION['id'], $scope, 'Scope_delivery');
}
//nip
if(!($_POST['nip'] === '')){
    $nip = $_POST['nip'];
    setUsersSql($_SESSION['id'], $nip, 'Nip');
}
//company name
if(!($_POST['company'] === '')){
    $company = $_POST['company'];
    setUsersSql($_SESSION['id'], $company, 'Company_name');
}
//invoices
if(isset($_POST['invoice'])){
    setUsersSql($_SESSION['id'], 1, 'Invoices');
}
else{
    setUsersSql($_SESSION['id'], 0, 'Invoices');
}
    
    
}

header('Content-Type: application/json');
echo json_encode($error);

?>
