<?php

session_start();
include_once "functions.php";
$error = [];
$error['price_empty'] = false;
$error['weight_empty'] = false;
$error['length_empty'] = false;
$error['height_empty'] = false;
$error['width_empty'] = false;
$error['load_f_empty'] = false;
$error['load_t_empty'] = false;
$error['adding_failed'] = false;
    
$execute = true;
if($_SESSION['logged'] == true && isset($_POST['vehicle_id'], $_POST['price'], $_POST['weight'], $_POST['length'], $_POST['height'], $_POST['width'], $_POST['date_f'], $_POST['date_t'], $_POST['about'])){
    if($_POST['price'] === ''){
        $error['price_empty'] = true;
        $execute = false;
    }
    if($_POST['weight'] === ''){
        $error['weight_empty'] = true;
        $execute = false;
    }
    if($_POST['length'] === ''){
        $error['length_empty'] = true;
        $execute = false;
    }
    if($_POST['height'] === ''){
        $error['height_empty'] = true;
        $execute = false;
    }
    if($_POST['width'] === ''){
        $error['width_empty'] = true;
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
    
    $vehicle = getVehicle($_POST['vehicle_id']);
    
    if($_SESSION['id'] == $vehicle->getId()){
        $execute = false;
    }
    
    if($execute){
        $add_time = date('Y-m-d H:i:s');
        
        $offer = new VehicleOffer(-1, $_POST['vehicle_id'], $_SESSION['id'], $_POST['price'], $add_time, $_POST['date_f'], $_POST['date_t'], $_POST['weight'], $_POST['length'], $_POST['height'], $_POST['width'], $_POST['about']);
        
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
