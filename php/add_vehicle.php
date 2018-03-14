<?php

session_start();
include_once "functions.php";

$error = [];
$error['title_empty'] = false;
$error['capacity_empty'] = false;
$error['pallets_empty'] = false;
$error['about_empty'] = false;
$error['country_empty'] = false;
$error['province_empty'] = false;
$error['city_empty'] = false;
$error['f_start_date'] = false;
$error['f_end_date'] = false;
$error['to_country_empty'] = false;
$error['to_province_empty'] = false;
$error['to_city_empty'] = false;
$error['t_start_date'] = false;
$error['t_end_date'] = false;
$error['adding_failed'] = false;
$error['date_error'] = false;
$error['vehicle_id'] = -1;


$execute = true;

if($_SESSION['logged'] == true && isset($_POST['title'], $_POST['capacity'], $_POST['pallets'], $_POST['about'], $_POST['country'], $_POST['province'], $_POST['city'], $_POST['f_start_date'], $_POST['f_end_date'], $_POST['to_country'], $_POST['to_province'], $_POST['to_city'], $_POST['t_start_date'], $_POST['t_end_date'])){
    
    
    if($_POST['title'] === ''){
        $error['title_empty'] = true;
        $execute = false;
    }
    if($_POST['capacity'] === ''){
        $error['capacity_empty'] = true;
        $execute = false;
    }
    if($_POST['pallets'] === ''){
        $error['pallets_empty'] = true;
        $execute = false;
    }
    if($_POST['about'] === ''){
        $error['about_empty'] = true;
        $execute = false;
    }
    if($_POST['country'] === ''){
        $error['country_empty'] = true;
        $execute = false;
    }
    if($_POST['province'] === ''){
        $error['province_empty'] = true;
        $execute = false;
    }
    if($_POST['city'] === ''){
        $error['city_empty'] = true;
        $execute = false;
    }
    if($_POST['f_start_date'] === ''){
        $error['f_start_date'] = true;
        $execute = false;
    }
    if($_POST['f_end_date'] === ''){
        $error['f_end_date'] = true;
        $execute = false;
    }
    if($_POST['to_country'] === ''){
        $error['to_country_empty'] = true;
        $execute = false;
    }
    if($_POST['to_province'] === ''){
        $error['to_province_empty'] = true;
        $execute = false;
    }
    if($_POST['to_city'] === ''){
        $error['to_city_empty'] = true;
        $execute = false;
    }
    if($_POST['t_start_date'] === ''){
        $error['t_start_date'] = true;
        $execute = false;
    }
    if($_POST['t_end_date'] === ''){
        $error['t_end_date'] = true;
        $execute = false;
    }
    
    $f_start_date = strtotime($_POST['f_start_date']);
    $f_end_date = strtotime($_POST['f_end_date']);
    $t_start_date = strtotime($_POST['t_start_date']);
    $t_end_date = strtotime($_POST['t_end_date']);
    
    if($f_start_date > $f_end_date){
        $error['date_error'] = true;
        $execute = false;
    }
    if($t_start_date > $t_end_date){
        $error['date_error'] = true;
        $execute = false;
    }
    
    
    if($execute){
        $add_time = date('Y-m-d H:i:s');
        
        //locs
        $loc_start = new Location(-1, $_POST['country'],  $_POST['province'], $_POST['city'], "", "", "");
        $loc_start_new = $loc_start->sqlInsert();
        
        $loc_end = new Location(-1, $_POST['to_country'], $_POST['to_province'], $_POST['to_city'], "", "", "");
        $loc_end_new = $loc_end->sqlInsert();
        
        if($loc_start_new != false && $loc_end_new != false){
            $vehicle = new Vehicle(-1, $_SESSION['id'], $_POST['title'], $_POST['capacity'], $_POST['pallets'], $_POST['about'], $add_time, $_POST['f_start_date'], $_POST['f_end_date'], $_POST['t_start_date'], $_POST['t_end_date'], $loc_start_new, $loc_end_new);
            
            $vehicle_new = $vehicle->sqlInsert();
            if($vehicle_new != false){
                 //added succesfully
                $error['vehicle_id'] = $vehicle_new->getId();
            }
            else{
                $error['adding_failed'] = true;
            }
        }
        else{
            $error['adding_failed'] = true;
        }
        
        
    }
    
    
    
}
header('Content-Type: application/json');
echo json_encode($error);



?>