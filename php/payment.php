<?php
session_start();
include 'functions.php';

if(isset($_POST['type'], $_SESSION['logged'], $_POST['id'])){
	
    $type = $_POST['type'];
    $id = $_POST['id'];
    $offer = null;
    
    if($type === "parcel"){
        $offer = getOffer($id);
    }
    else if($type === "vehicle"){
        $offer = getVehicleOffer($id);
    }
    $kwota = $offer->getPrice() * $tax;
    //$_SESSION['kwota'] = $kwota;
    	
	$amount = $kwota*100;
	$session_id = getPaymentId();
	$merchant_id = "----------";
	$pos_id = "-----------";
	$currency = "PLN";
	$desc = "Doladowanie konta -----";
	$country = "PL";
	$email = getEmail($_SESSION['id']);
	$url_return = "---------";
	$url_status = "----------------";
	$api_version = "3.2";
	$crc = "-------------";
	$code = $session_id."|".$merchant_id."|".$amount."|".$currency."|".$crc;
	$sign = md5($code);
	
	addNewPayment($_SESSION['id'], $amount, $session_id, $type, $id);
	//zapisac do db tranzakcje steamid | kwota |  session_id
	
$url = 'https://secure.przelewy24.pl/trnDirect';
$data = array('p24_session_id' => $session_id,
 'p24_merchant_id' => $merchant_id,
 'p24_pos_id' => $pos_id,
 'p24_amount' => $amount,
 'p24_currency' => $currency,
 'p24_description' => $desc,
 'p24_country' => $country,
 'p24_url_return' => $url_return,
 'p24_api_version' => $api_version,
 'p24_email' => $email,
 'p24_sign' => $sign);
 
 echo('<form id="pay_form" action="'.$url.'" method="post">
 <input type="hidden" name="p24_session_id" value="'.$session_id.'">
  <input type="hidden" name="p24_merchant_id" value="'.$merchant_id.'">
   <input type="hidden" name="p24_pos_id" value="'.$pos_id.'">
    <input type="hidden" name="p24_amount" value="'.$amount.'">
	 <input type="hidden" name="p24_currency" value="'.$currency.'">
	  <input type="hidden" name="p24_description" value="'.$desc.'">
	   <input type="hidden" name="p24_country" value="'.$country.'">
	    <input type="hidden" name="p24_url_return" value="'.$url_return.'">
		 <input type="hidden" name="p24_api_version" value="'.$api_version.'">
		 <input type="hidden" name="p24_email" value="'.$email.'">
		 <input type="hidden" name="p24_url_status" value="'.$url_status.'">
		  <input type="hidden" name="p24_sign" value="'.$sign.'">
 </form>
 
 <script>
	document.getElementById("pay_form").submit();
 </script>
 
 ');
 
	
}


?>
