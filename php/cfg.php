<?php
//zrobic to obiektowo mejbi
$host = "localhost";
$username = "root";
$password = "";
$dbname = "speedmtrans";

//pass min/max lenght
$pass_min = 6;
$pass_max = 16;
    
//pass hash
$options = [
    'cost' => 12,
];

//items on site
$items_per_site = 20;

//google maps api key
$maps_api = "AIzaSyDdFweakk_mNW9MFy7qKX7XeDS65gEIrQ0";

//% kwoty od oferty pobierany
$tax = 0.1;

//smtp data - email send
$smtp_host = "smtp.gmail.com";
$smtp_username = "arafair@gmail.com";
$smtp_pass = "Aniajanowska1";
$smtp_name = "SpeedMTrans.eu";

//mail confirm - link *link* - ad while sending it
//avaiable in html <b><u> etc..
$mail_register_msg = "Dziękujemy za rejestracje w SpeedMTrans.eu!
Potwierdź swój adres e-mail klikając w poniższy link.
*link*";

$mail_register_subject = "Rejestracja SppedMTrans";

//parcel accept
//for offer author
$mail_parcel_msg = "";

$mail_parcel_subject = "";
//for sub-offer author
$mail_offer_parcel_msg = "";

$mail_offer_parcel_subject = "";

//vehicle accept
//for offer author
$mail_vehicle_msg = "";

$mail_vehicle_subject = "";
//for sub-offer author
$mail_offer_vehicle_msg = "";

$mail_offer_vehicle_subject = "";




?>