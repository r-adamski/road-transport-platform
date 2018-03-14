<?php

session_start();
include_once "functions.php";

$error = [];
$error['cat_empty'] = false;
$error['title_empty'] = false;
$error['length_empty'] = false;
$error['width_empty'] = false;
$error['height_empty'] = false;
$error['weight_empty'] = false;
$error['amount_empty'] = false;
$error['about_empty'] = false;
$error['country_empty'] = false;
$error['province_empty'] = false;
$error['city_empty'] = false;
$error['post_code_empty'] = false;
$error['street_empty'] = false;
$error['number_empty'] = false;
$error['f_start_date'] = false;
$error['f_end_date'] = false;
$error['to_country_empty'] = false;
$error['to_province_empty'] = false;
$error['to_city_empty'] = false;
$error['to_post_code_empty'] = false;
$error['to_street_empty'] = false;
$error['to_number_empty'] = false;
$error['t_start_date'] = false;
$error['t_end_date'] = false;
$error['adding_failed'] = false;
$error['date_error'] = false;
$error['parcel_id'] = -1;


$execute = true;

if($_SESSION['logged'] == true && isset($_POST['category'], $_POST['title'], $_POST['length'], $_POST['width'], $_POST['height'], $_POST['weight'], $_POST['amount'], $_POST['about'], $_POST['country'], $_POST['province'], $_POST['city'], $_POST['post_code'], $_POST['street'], $_POST['number'], $_POST['f_start_date'], $_POST['f_end_date'], $_POST['to_country'], $_POST['to_province'], $_POST['to_city'], $_POST['to_post_code'], $_POST['to_street'],  $_POST['to_number'],
$_POST['t_start_date'], $_POST['t_end_date'])){
    
    
    if($_POST['category'] === ''){
        $error['cat_empty'] = true;
        $execute = false;
    }
    if($_POST['title'] === ''){
        $error['title_empty'] = true;
        $execute = false;
    }
    if($_POST['length'] === ''){
        $error['length_empty'] = true;
        $execute = false;
    }
    if($_POST['width'] === ''){
        $error['width_empty'] = true;
        $execute = false;
    }
    if($_POST['height'] === ''){
        $error['height_empty'] = true;
        $execute = false;
    }
    if($_POST['weight'] === ''){
        $error['weight_empty'] = true;
        $execute = false;
    }
    if($_POST['amount'] === ''){
        $error['amount_empty'] = true;
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
    if($_POST['post_code'] === ''){
        $error['post_code_empty'] = true;
        $execute = false;
    }
    if($_POST['street'] === ''){
        $error['street_empty'] = true;
        $execute = false;
    }
    if($_POST['number'] === ''){
        $error['number_empty'] = true;
        $execute = false;
    }
    if($_POST['f_start_date'] === ''){
        $error['f_start_date_empty'] = true;
        $execute = false;
    }
    if($_POST['f_end_date'] === ''){
        $error['f_end_date_empty'] = true;
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
    if($_POST['to_post_code'] === ''){
        $error['to_post_code_empty'] = true;
        $execute = false;
    }
    if($_POST['to_street'] === ''){
        $error['to_street_empty'] = true;
        $execute = false;
    }
    if($_POST['to_number'] === ''){
        $error['to_number_empty'] = true;
        $execute = false;
    }
    if($_POST['t_start_date'] === ''){
        $error['t_start_date_empty'] = true;
        $execute = false;
    }
    if($_POST['t_end_date'] === ''){
        $error['t_end_date_empty'] = true;
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
        $loc_start = new Location(-1, $_POST['country'],  $_POST['province'], $_POST['city'], $_POST['street'], $_POST['number'], $_POST['post_code']);
        $loc_start_new = $loc_start->sqlInsert();
        
        $loc_end = new Location(-1, $_POST['to_country'], $_POST['to_province'], $_POST['to_city'], $_POST['to_street'], $_POST['to_number'], $_POST['to_post_code']);
        $loc_end_new = $loc_end->sqlInsert();
        
        if($loc_start_new != false && $loc_end_new != false){
            $parcel = new Parcel(-1, $_SESSION['id'], $_POST['category'], $_POST['title'], $_POST['length'], $_POST['width'], $_POST['height'], $_POST['weight'], $_POST['amount'], $_POST['about'], $add_time, $_POST['f_start_date'], $_POST['f_end_date'], $_POST['t_start_date'], $_POST['t_end_date'], $loc_start_new, $loc_end_new);
            
            $parcel_new = $parcel->sqlInsert();
            if($parcel_new != false){
                 //added succesfully
                $error['parcel_id'] = $parcel_new->getId();
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