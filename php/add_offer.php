<?php

session_start();
include_once "functions.php";
$error = [];
$error['price_empty'] = false;
$error['time_empty'] = false;
$error['type_empty'] = false;
$error['load_f_empty'] = false;
$error['load_t_empty'] = false;
$error['adding_failed'] = false;
$error['date_error'] = false;
    
$execute = true;
if($_SESSION['logged'] == true && isset($_POST['parcel_id'], $_POST['price'], $_POST['transport_time'], $_POST['transport_type'], $_POST['date_f'], $_POST['date_t'], $_POST['about'])){
    
    if($_POST['price'] === ''){
        $error['price_empty'] = true;
        $execute = false;
    }
    if($_POST['transport_time'] === ''){
        $error['time_empty'] = true;
        $execute = false;
    }
    if($_POST['transport_type'] === ''){
        $error['type_empty'] = true;
        $execute = false;
    }
    if($_POST['date_f'] === ''){
        $error['load_f_empty'] = true;
        $execute = false;
    }
    if($_POST['date_t'] === ''){
        $error['load_t_empty'] = true;
        $execute = false;
    }
    
    $date_f = strtotime($_POST['date_f']);
    $date_t = strtotime($_POST['date_t']);
    if($date_t < $date_f){
        $error['date_error'] = true;
        $execute = false;
    }
    
    $parcel = getParcel($_POST['parcel_id']);
    if($_SESSION['id'] == $parcel->getAuthor()){
        $execute = false;
    }
    
    if($execute){
        $add_time = date('Y-m-d H:i:s');
        
        $offer = new Offer(-1, $_POST['parcel_id'], $_SESSION['id'], $_POST['price'], $add_time, $_POST['date_f'], $_POST['date_t'], $_POST['transport_time'], $_POST['transport_type'], $_POST['about']);
        
        $offer_new = $offer->sqlInsert();
            if($offer_new != false){
                 //added succesfully
                
            }
            else{
                $error['adding_failed'] = true;
            }
        
    }
    
}

header('Content-Type: application/json');
echo json_encode($error);

?>
