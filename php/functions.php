<?php
include_once "used.php";
include_once "get.php";
include_once "set.php";
include_once "objects.php";


function sendMail($sb_email, $subject, $message){
    global $smtp_host, $smtp_username, $smtp_pass, $smtp_name;
    require "libs/mailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;
    
    
    
$mail->isSMTP();     
//$mail->SMTPDebug = 2; // Set mailer to use SMTP
//$mail->Debugoutput = function($str, $level) {error_log($str);};
$mail->Host = $smtp_host;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $smtp_username;                 // SMTP username
$mail->Password = $smtp_pass;                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom($smtp_username, $smtp_name);
$mail->addAddress($sb_email);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = $message;

    
if(!$mail->send()) {
    //error_log('Mailer Error: ' . $mail->ErrorInfo,0);
} else {
    //error_log('Message has been sent', 0);
}
    
}

function registerUser($name, $add_time, $email, $phone, $pass, $payment, $range, $nip, $company){
    global $host, $username, $password, $dbname, $options, $mail_register_msg, $mail_register_subject;
    
    $hash = password_hash($pass, PASSWORD_BCRYPT, $options);
    //$token = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO users(Name, Register_date, Email, Tel, Password, Payment_methods, Scope_delivery, Nip, Company_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")){
            $stmt->bind_param("sssssssss", $name, $add_time, $email, $phone, $hash, $payment, $range, $nip, $company);
            $stmt->execute();
            
            $_SESSION['logged'] = true;
            $_SESSION['mail_to_confirm'] = true;
            $_SESSION['id'] = getId($email);
            
            
            //mail
            $mail_confirm = "<a href='csgokeys.pl/smt/php/confirm.php?token=".$_SESSION['id']."' >POTWIERDZ</a>";
            $msg = str_replace("*link*", $mail_confirm, $mail_register_msg);
            
            sendMail($email, $mail_register_subject, $msg);
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
}


function passCorrect($email, $pass){
    global $host, $username, $password, $dbname, $options;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Password` FROM `users` WHERE `Email`= ?")){
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 0){
                return false;
            }
            else if($stmt->num_rows == 1){
                $stmt->bind_result($pass_hash);
                while($stmt->fetch()){
                    if(password_verify($pass, $pass_hash)){
                        $_SESSION['id'] = getId($email);
                        return true;
                    }
                }
            }
            else{
                return false;
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return false;
}

function isSelected($option){
    if(isset($_GET[$option])){
        if($_GET[$option] == 1){
            return true;
        }
    }
    return false;
}

function getCategory($option){
    if(isSelected($option)){
        return $_GET[$option];
    }
    return 0;
}

function acceptParcelOffer($id){
    global $host, $username, $password, $dbname, $options;
    //get offer
    $offer = getOffer($id);
    
    
    //get parcel
    $parcel = getParcel($offer->getFor_id());
    
    
    //move parcel
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO parcels_history(Id, Author, Category, Title, Length, Width, Height, Weight, Amount, About, Add_date, F_start_date, F_end_date, T_start_date, T_end_date, Loc_start, Loc_end, Offer_choosed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
            $stmt->bind_param("iissddddissssssiii", $parcel->getId(), $parcel->getAuthor(), $parcel->getCategory(), $parcel->getTitle(), $parcel->getLength(), $parcel->getWidth(), $parcel->getAmount(), $parcel->getAbout(), $parcel->getAdd_date(), $parcel->getFrom_start_date(), $parcel->getFrom_end_date(), $parcel->getTo_start_date(), $parcel->getTo_end_date(), $parcel->getLoc_start(), $parcel->getLoc_end(), $offer->getId());
            $stmt->execute();
            
                //delete parcel only if insert succesfull
                if($stmt->affected_rows == 1){
                    $stmt_d = $conn->stmt_init();
                    if($stmt_d->prepare("DELETE FROM parcels WHERE Id= ?")){
                        $stmt_d->bind_param("i", $parcel->getId());
                        $stmt_d->execute();
                        if($stmt_d->affected_rows != 1){
                            return false;
                        }
                    }
                }
            else{
                return false;
            }
                
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return true;
}
    

function acceptVehicleOffer($id){
    global $host, $username, $password, $dbname, $options;
    //get offer
    $offer = getVehicleOffer($id);
    
    
    //get parcel
    $vehicle = getVehicle($offer->getFor_id());
    
    
    //move parcel
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO vehicles_history(Id, Author, Title, Capacity, Pallets, About, Add_date, F_start_date, F_end_date, T_start_date, T_end_date, Loc_start, Loc_end, Offer_choosed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
            $stmt->bind_param("iisdissssssiii", $vehicle->getId(), $vehicle->getAuthor(), $vehicle->getTitle(), $vehicle->getCapacity(), $vehicle->getPallets(), $vehicle->getAbout(), $vehicle->getAdd_date(), $vehicle->getFrom_start_date(), $vehicle->getFrom_end_date(), $vehicle->getTo_start_date(), $vehicle->getTo_end_date(), $vehicle->getLoc_start(), $vehicle->getLoc_end(), $offer->getId());
            $stmt->execute();
            
                //delete parcel only if insert succesfull
                if($stmt->affected_rows == 1){
                    $stmt_d = $conn->stmt_init();
                    if($stmt_d->prepare("DELETE FROM vehicles WHERE Id= ?")){
                        $stmt_d->bind_param("i", $vehicle->getId());
                        $stmt_d->execute();
                        if($stmt_d->affected_rows != 1){
                            return false;
                        }
                    }
                }
            else{
                return false;
            }
                
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return true;
}
    

function get_web_page($url, $data) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120   // time-out on response
    ); 

    $ch = curl_init($url);
	 curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,join("&",$data));
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}

function getPaymentAmount($id){
	global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Amount` FROM `payments` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($amount);
                while($stmt->fetch()){
                    return $amount;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("AmountGetERROR: null!", 0);
    return 0;
}

function getPaymentType($id){
	global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `type` FROM `payments` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($type);
                while($stmt->fetch()){
                    return $type;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("TypeGetERROR: null!", 0);
    return null;
}

function getPaymentOfferId($id){
	global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `offer_id` FROM `payments` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($offer);
                while($stmt->fetch()){
                    return $offer;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("OfferGetERROR: null!", 0);
    return null;
}

function setPaymentDone($id){
	global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE payments SET `Payed`= 1 WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}

function addNewPayment($steamid, $amount, $id, $type, $offer_id){
	global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO payments(Id, User_id, Amount, Payed,  type, offer_id) VALUES (?, ?, ?, 0, ?, ?)")){
            $stmt->bind_param("isisi", $id, $steamid, $amount, $type, $offer_id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}

function getPaymentId(){
	global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM `payments`")){
            $stmt->execute();
            $stmt->store_result();
            
			$id = $stmt->num_rows + 1;
			return $id;
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("PaymentIdGetERROR: null!", 0);
    return "";
}

?>