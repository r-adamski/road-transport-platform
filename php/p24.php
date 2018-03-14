<?php
session_start();
include "functions.php";

if(isset($_POST['p24_merchant_id'], $_POST['p24_pos_id'], $_POST['p24_session_id'], $_POST['p24_amount'],
$_POST['p24_currency'], $_POST['p24_order_id'], $_POST['p24_method'], $_POST['p24_statement'], $_POST['p24_sign'])){
	
	
	$url = "https://secure.przelewy24.pl/trnVerify";
	
	$data = array();
    $data[] = "p24_merchant_id=".$_POST['p24_merchant_id'];
	$data[] = "p24_pos_id=".$_POST['p24_pos_id'];
	$data[] = "p24_session_id=".$_POST['p24_session_id'];
	$data[] = "p24_amount=".$_POST['p24_amount'];
	$data[] = "p24_currency=".$_POST['p24_currency'];
	$data[] = "p24_order_id=".$_POST['p24_order_id'];
	$data[] = "p24_sign=".$_POST['p24_sign'];
	
	$amount = getPaymentAmount($_POST['p24_session_id']);
	
	if($amount <= $_POST['p24_amount']){
	
	$response = get_web_page($url, $data);
	
	if($response === "error=0"){
        //platnosc dobra
        setPaymentDone($_POST['p24_session_id']);
        $type = getPaymentType($_POST['p24_session_id']);
        $id = getPaymentOfferId($_POST['p24_session_id']);
        //akceptowanie oferty
        if($type === "parcel"){
            acceptParcelOffer($id);
        }
        else if($type === "vehicle"){
            acceptVehicleOffer($id);
        }
        //wysylanie maila z info
        if($type === "parcel"){
            $offer = getOffer($id);
            $author_id = $offer->getAuthor();
            $author_email = getEmail($author_id);
            
            $parcel_id = $offer->getFor_id();
            $parcel = getParcel($parcel_id);
            $offer_author_id = $parcel->getFor_id();
            $offer_author_email = getEmail($offer_author_id);
            
            //sendMail($email, $mail_register_subject, $msg);
        }
        else if($type === "vehicle"){
            $offer = getVehicleOffer($id); 
            $author_id = $offer->getAuthor();
            $author_email = getEmail($author_id);
            
            $vehicle_id = $offer->getFor_id();
            $vehicle = getVehicle($vehicle_id);
            $vehicle_author_id = $vehicle->getFor_id();
            $vehicle_author_email = getEmail($vehicle_author_id);
            //send mail
        }
        
	}else{
		error_log("BLAD BLAD BLAD w platnosci!!!!!", 0);
		error_log($response, 0);
	}
	
	}
	else{
		error_log("Przelew o nizszej kwocie", 0);
		error_log($_POST['p24_session_id'], 0);
	}
	
}

?>
