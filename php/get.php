<?php
include_once "cfg.php";
include_once "objects.php";

function getAllOpinions($user_id){
    $opinions = array();
    
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM opinions WHERE Opinion_for= ? ORDER BY Add_date DESC")){
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $type, $add_date, $author, $opinion_for, $opinion);
            
            while($stmt->fetch()){
                $opinion = new Opinion($id, $type, strtotime($add_date), $author, $opinion_for, $opinion);
                array_push($opinions, $opinion);
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return $opinions;
}

function getLastOpinions($user_id){
    $opinions = array();
    
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM opinions WHERE Opinion_for= ? ORDER BY Add_date DESC LIMIT 3")){
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $type, $add_date, $author, $opinion_for, $opinion);
            
            while($stmt->fetch()){
                $opinion = new Opinion($id, $type, strtotime($add_date), $author, $opinion_for, $opinion);
                array_push($opinions, $opinion);
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return $opinions;
}


function getUserNameWithOpinions($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT Name, Positive_opinions, Neutral_opinions, Negative_opinions FROM users WHERE Id= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name, $positive, $neutral, $negative);
            
            while($stmt->fetch()){
                $amount = $positive+$neutral+$negative;
                echo $name."(".$amount.")";
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return null;
    
}



function getParcelsAmount($furniture, $moving, $cars, $loads, $boxes, $motocycles, $other_vehicles, $special_care, $other, $weight_min, $weight_max){
    global $host, $username, $password, $dbname;
    
    
    $where_used = false;
    
    $select = "SELECT COUNT(Id) AS amount FROM parcels ";
    if($furniture){
        $select .= "WHERE Category='Furniture' ";
        $where_used = true;
    }
    if($moving){
        if($where_used){
            $select .= "OR Category='moving' ";
        }
        else{
            $select .= "WHERE Category='moving' ";
            $where_used = true;
        }
    }
     if($cars){
        if($where_used){
            $select .= "OR Category='cars' ";
        }
        else{
            $select .= "WHERE Category='cars' ";
            $where_used = true;
        }
    }
     if($loads){
        if($where_used){
            $select .= "OR Category='loads' ";
        }
        else{
            $select .= "WHERE Category='loads' ";
            $where_used = true;
        }
    }
     if($boxes){
        if($where_used){
            $select .= "OR Category='boxes' ";
        }
        else{
            $select .= "WHERE Category='boxes' ";
            $where_used = true;
        }
    }
     if($motocycles){
        if($where_used){
            $select .= "OR Category='motocycles' ";
        }
        else{
            $select .= "WHERE Category='motocycles' ";
            $where_used = true;
        }
    }
     if($other_vehicles){
        if($where_used){
            $select .= "OR Category='other_vehicles' ";
        }
        else{
            $select .= "WHERE Category='other_vehicles' ";
            $where_used = true;
        }
    }
     if($special_care){
        if($where_used){
            $select .= "OR Category='special_care' ";
        }
        else{
            $select .= "WHERE Category='special_care' ";
            $where_used = true;
        }
    }
     if($other){
        if($where_used){
            $select .= "OR Category='other' ";
        }
        else{
            $select .= "WHERE Category='other' ";
            $where_used = true;
        }
    }
    if($weight_min != -1){
        if($where_used){
            $select .= "AND Weight>= ? ";
        }
        else{
            $select .= "WHERE Weight>= ? ";
            $where_used = true;
        }
    }
    if($weight_max != -1){
        if($where_used){
            $select .= "AND Weight<= ?";
        }
        else{
            $select .= "WHERE Weight<= ?";
            $where_used = true;
        }
    }
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare($select)){
            //1
            if($weight_min != -1 && $weight_max != -1){
                $stmt->bind_param("dd", $weight_min, $weight_max);
            }
            //2
            else if($weight_min != -1 && $weight_max == -1){
                $stmt->bind_param("d", $weight_min);
            }
            //3
            else if($weight_min == -1 && $weight_max != -1){
                $stmt->bind_param("d", $weight_max);
            }
            
            
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($amount);
            
            while($stmt->fetch()){
                return $amount; 
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return null;
}

function getVehiclesAmount(){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT COUNT(*) FROM `vehicles`")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($amount);
            
            while($stmt->fetch()){
                return $amount; 
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    return null;
}

function getProfile($id){
    $profile = null;
    global $host, $username, $password, $dbname;
    
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT Id, Name, Register_date, Email, Tel, Payment_methods, Scope_delivery, Nip, Company_name, Invoices, Positive_opinions, Neutral_opinions, Negative_opinions FROM users WHERE Id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
                $stmt->bind_result($id, $name, $date, $email, $tel, $payment_methods, $scope_delivery, $nip, $company_name, $invoices, $positive, $neutral, $negative);
                while($stmt->fetch()){
                    
                    $profile = new Profile($id, $name, strtotime($date), $email, $tel, $payment_methods, $scope_delivery, $nip, $company_name, $invoices, $positive, $neutral, $negative);
                    
                }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $profile;
}

function getParcel($id){
    $parcel = null;
    global $host, $username, $password, $dbname;
    
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM parcels WHERE Id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
                $stmt->bind_result($id, $author, $category, $title, $length,  $width, $height, $weight, $amount, $about, $add_date, $f_start_date, $f_end_date, $t_start_date, $t_end_date, $loc_start, $loc_end);
                while($stmt->fetch()){
                    
                    $add_t = strtotime($add_date);
                    //$myFormatForView = date("Y-m-d H:i:s", $time);
                    $f_start_t = strtotime($f_start_date);
                    $f_end_t = strtotime($f_end_date);
                    $t_start_t = strtotime($t_start_date);
                    $t_end_t = strtotime($t_end_date);
                        
                    $loc_s = getLoc($loc_start);
                    $loc_e = getLoc($loc_end);
                    
                    
                    $parcel = new Parcel($id, $author, $category, $title, $length, $width, $height, $weight, $amount, $about, $add_t, $f_start_t, $f_end_t, $t_start_t, $t_end_t, $loc_s, $loc_e);
                }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $parcel;
}

function getVehicle($id){
    $vehicle = null;
    global $host, $username, $password, $dbname;
    
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM vehicles WHERE Id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
                $stmt->bind_result($id, $author, $title, $capacity, $pallets, $about, $add_date, $f_start_date, $f_end_date, $t_start_date, $t_end_date, $loc_start, $loc_end);
                while($stmt->fetch()){
                    
                    $add_t = strtotime($add_date);
                    //$myFormatForView = date("Y-m-d H:i:s", $time);
                    $f_start_t = strtotime($f_start_date);
                    $f_end_t = strtotime($f_end_date);
                    $t_start_t = strtotime($t_start_date);
                    $t_end_t = strtotime($t_end_date);
                        
                    $loc_s = getLoc($loc_start);
                    $loc_e = getLoc($loc_end);
                    
                    
                    $vehicle = new Vehicle($id, $author, $title, $capacity, $pallets, $about, $add_t, $f_start_t, $f_end_t, $t_start_t, $t_end_t, $loc_s, $loc_e);
                }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $vehicle;
}

function getOffersFor($id){
    global $host, $username, $password, $dbname;
    $offers = array();
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM offers WHERE For_id= ? ORDER BY Add_date DESC")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($id, $for_id, $author, $price, $add_date, $loading_f, $loading_t, $transport_time, $transport_type, $about);
            
            while($stmt->fetch()){
                $offer = new Offer($id, $for_id, $author, $price, strtotime($add_date), strtotime($loading_f), strtotime($loading_t), $transport_time, $transport_type, $about);
                array_push($offers, $offer);
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $offers;
}

function getVehicleOffersFor($id){
    global $host, $username, $password, $dbname;
    $offers = array();
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM vehicle_offers WHERE For_id= ? ORDER BY Add_date DESC")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($id, $for_id, $author, $price, $add_date, $loading_f, $loading_t, $weight, $length, $height, $width, $about);
            
            while($stmt->fetch()){
                $offer = new VehicleOffer($id, $for_id, $author, $price, strtotime($add_date), strtotime($loading_f), strtotime($loading_t), $weight, $length, $height, $width, $about);
                array_push($offers, $offer);
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $offers;
}

function getOffer($id){
    global $host, $username, $password, $dbname;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM offers WHERE Id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($id, $for_id, $author, $price, $add_date, $loading_f, $loading_t, $transport_time, $transport_type, $about);
            
            while($stmt->fetch()){
                $offer = new Offer($id, $for_id, $author, $price, strtotime($add_date), strtotime($loading_f), strtotime($loading_t), $transport_time, $transport_type, $about);
                return $offer;
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return null;
}

function getVehicleOffer($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM vehicle_offers WHERE Id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($id, $for_id, $author, $price, $add_date, $loading_f, $loading_t, $weight, $length, $height, $width, $about);
            
            while($stmt->fetch()){
                $offer = new VehicleOffer($id, $for_id, $author, $price, strtotime($add_date), strtotime($loading_f), strtotime($loading_t), $weight, $length, $height, $width, $about);
                return $offer;
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return null;
}

function getComment($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM comments WHERE Id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($id, $offer_type, $offer_id, $author, $add_date, $content);
            
            while($stmt->fetch()){
                $comment = new Comment($id, $offer_type, $offer_id, $author, strtotime($add_date), $content);
                return $comment;
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return null;
}

function getCommentsOffersFor($type, $id){
    global $host, $username, $password, $dbname;
    $comments = array();
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM comments WHERE Offer_type= ? AND Offer_id= ? ORDER BY Add_date DESC")){
            $stmt->bind_param("si", $type, $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($id, $offer_type, $offer_id, $author, $add_date, $content);
            
            while($stmt->fetch()){
                $comment = new Comment($id, $offer_type, $offer_id, $author, strtotime($add_date), $content);
                array_push($comments, $comment);
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $comments;
}

function getUserParcelsAmount($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT COUNT(Id) AS Amount FROM parcels WHERE Author= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($amount);
            
            while($stmt->fetch()){
                return $amount;
            }

        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    
    return 0;
}

function getWonOffersAmount($id){
    return 0;
    //niema wygranych jeszcze dokonczonych
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT COUNT(Id) as Amount FROM parcels WHERE Author= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($amount);
            
            while($stmt->fetch()){
                return $amount;
            }

            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    
    return 0;
}

function getAllOffersAmount($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT COUNT(ID) as Amount FROM offers WHERE Author= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($amount);
            
            while($stmt->fetch()){
                return $amount;
            }

            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    
    return 0;
}

function getAllCommentsAmount($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT COUNT(ID) as Amount FROM comments WHERE Author= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            $stmt->bind_result($amount);
            
            while($stmt->fetch()){
                return $amount;
            }

            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    
    return 0;
}

function getOffersAmountFor($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM offers WHERE For_id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            return $stmt->num_rows;

            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    
    return 0;
}

function getVehicleOffersAmountFor($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM vehicle_offers WHERE For_id= ?")){
            $stmt->bind_param("i", $id);
        
            $stmt->execute();
            $stmt->store_result();
            
            return $stmt->num_rows;

            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    
    return 0;
}

function getParcels($amount, $offset, $furniture, $moving, $cars, $loads, $boxes, $motocycles, $other_vehicles, $special_care, $other, $weight_min, $weight_max){
    global $host, $username, $password, $dbname;
    
    
    $items = array();
    
    $where_used = false;
    
    $select = "SELECT * FROM parcels ";
    if($furniture){
        $select .= "WHERE Category='Furniture' ";
        $where_used = true;
    }
    if($moving){
        if($where_used){
            $select .= "OR Category='moving' ";
        }
        else{
            $select .= "WHERE Category='moving' ";
            $where_used = true;
        }
    }
     if($cars){
        if($where_used){
            $select .= "OR Category='cars' ";
        }
        else{
            $select .= "WHERE Category='cars' ";
            $where_used = true;
        }
    }
     if($loads){
        if($where_used){
            $select .= "OR Category='loads' ";
        }
        else{
            $select .= "WHERE Category='loads' ";
            $where_used = true;
        }
    }
     if($boxes){
        if($where_used){
            $select .= "OR Category='boxes' ";
        }
        else{
            $select .= "WHERE Category='boxes' ";
            $where_used = true;
        }
    }
     if($motocycles){
        if($where_used){
            $select .= "OR Category='motocycles' ";
        }
        else{
            $select .= "WHERE Category='motocycles' ";
            $where_used = true;
        }
    }
     if($other_vehicles){
        if($where_used){
            $select .= "OR Category='other_vehicles' ";
        }
        else{
            $select .= "WHERE Category='other_vehicles' ";
            $where_used = true;
        }
    }
     if($special_care){
        if($where_used){
            $select .= "OR Category='special_care' ";
        }
        else{
            $select .= "WHERE Category='special_care' ";
            $where_used = true;
        }
    }
     if($other){
        if($where_used){
            $select .= "OR Category='other' ";
        }
        else{
            $select .= "WHERE Category='other' ";
            $where_used = true;
        }
    }
    if($weight_min != -1){
        if($where_used){
            $select .= "AND Weight>= ? ";
        }
        else{
            $select .= "WHERE Weight>= ? ";
            $where_used = true;
        }
    }
    if($weight_max != -1){
        if($where_used){
            $select .= "AND Weight<= ? ";
        }
        else{
            $select .= "WHERE Weight<= ? ";
            $where_used = true;
        }
    }
    $select .= "ORDER BY Add_date DESC LIMIT ? OFFSET ?";
    
    //parcels
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare($select)){
            //1
            if($weight_min != -1 && $weight_max != -1){
                $stmt->bind_param("ddii", $weight_min, $weight_max, $amount, $offset);
            }
            //2
            else if($weight_min != -1 && $weight_max == -1){
                $stmt->bind_param("dii", $weight_min, $amount, $offset);
            }
            //3
            else if($weight_min == -1 && $weight_max != -1){
                $stmt->bind_param("dii", $weight_max, $amount, $offset);
            }
            //4
            else{
                $stmt->bind_param("ii", $amount, $offset);
            }
            $stmt->execute();
            $stmt->store_result();
            
                $stmt->bind_result($id, $author, $category, $title, $length,  $width, $height, $weight, $amount, $about, $add_date, $f_start_date, $f_end_date, $t_start_date, $t_end_date, $loc_start, $loc_end);
                while($stmt->fetch()){
                    
                    $add_t = strtotime($add_date);
                    //$myFormatForView = date("Y-m-d H:i:s", $time);
                    $f_start_t = strtotime($f_start_date);
                    $f_end_t = strtotime($f_end_date);
                    $t_start_t = strtotime($t_start_date);
                    $t_end_t = strtotime($t_end_date);
                        
                    $loc_s = getLoc($loc_start);
                    $loc_e = getLoc($loc_end);
                    
                    
                    $parcel = new Parcel($id, $author, $category, $title, $length, $width, $height, $weight, $amount, $about, $add_t, $f_start_t, $f_end_t, $t_start_t, $t_end_t, $loc_s, $loc_e);
                    
                    array_push($items, $parcel);
                }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $items;
}

function getVehicles($amount, $offset){
    global $host, $username, $password, $dbname;
    $items = array();
    
    //vehicles
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM `vehicles` ORDER BY `Add_date` DESC LIMIT ? OFFSET ?")){
            $stmt->bind_param("ii", $amount, $offset);
            $stmt->execute();
            $stmt->store_result();
            
                $stmt->bind_result($id, $author, $title, $capacity, $pallets, $about, $add_date, $f_start_date, $f_end_date, $t_start_date, $t_end_date, $loc_start, $loc_end);
                while($stmt->fetch()){
                    
                    $add_t = strtotime($add_date);
                    $f_start_t = strtotime($f_start_date);
                    $f_end_t = strtotime($f_end_date);
                    $t_start_t = strtotime($t_start_date);
                    $t_end_t = strtotime($t_end_date);
                    
                    $loc_s = getLoc($loc_start);
                    $loc_e = getLoc($loc_end);
                    
                    $vehicle = new Vehicle($id, $author, $title, $capacity, $pallets, $about, $add_t, $f_start_t, $f_end_t, $t_start_t, $t_end_t, $loc_s, $loc_e);
                    
                    array_push($items, $vehicle);
                }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    return $items;
}

function getLoc($id){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM `locs` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
                $stmt->bind_result($id, $country, $province, $city, $street, $nr, $postcode);

                while($stmt->fetch()){
                    $loc = new Location($id, $country, $province, $city, $street, $nr, $postcode);
                    return $loc;
                }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    } 
    error_log("Location not found!", 0);
    return null;
    
}


function getId($email){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Id` FROM `users` WHERE `Email`= ?")){
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($id);
                while($stmt->fetch()){
                    return $id;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    } 
    error_log("GETfunction1: null!", 0);
    return "";
}


function getName($id){
global $host, $username, $password, $dbname;
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Name` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($name);
                while($stmt->fetch()){
                    return $name;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction2: null!", 0);
    return "";
}

function getEmail($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Email` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($email);
                while($stmt->fetch()){
                    return $email;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction3: null!", 0);
    return "";
}

function isEmailConfirmed($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Email_confirmed` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($email);
                while($stmt->fetch()){
                    if($email === "confirmed"){
                        return true;
                    }
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction4: null!", 0);
    return false;
}


function getTel($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Tel` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($tel);
                while($stmt->fetch()){
                    return $tel;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction5: null!", 0);
    return "";
}

function getPayment($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Payment_methods` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($payment);
                while($stmt->fetch()){
                    return $payment;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction6: null!", 0);
    return "";
}

function getScope($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Scope_delivery` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($scope);
                while($stmt->fetch()){
                    return $scope;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction7: null!", 0);
    return "";
}


function getNip($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Nip` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($nip);
                while($stmt->fetch()){
                    return $nip;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction8: null!", 0);
    return "";
}


function getCompany($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Company_name` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($company);
                while($stmt->fetch()){
                    return $company;
                }
            }
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
    
    error_log("GETfunction9: null!", 0);
    return "";
}


function giveInvoices($id){
global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT `Invoices` FROM `users` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $stmt->bind_result($invoices);
                while($stmt->fetch()){
                    if($invoices == 1){
                        return true;
                    }
                }
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

?>
