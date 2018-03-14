<?php
include_once "cfg.php";

class Vehicle{
    private $id;
    private $author;
    private $title;
    private $capacity;
    private $pallets;
    private $about;
    private $add_date;
    private $from_start_date;
    private $from_end_date;
    private $to_start_date;
    private $to_end_date;
    private $loc_start;
    private $loc_end;
    
    //if id == -1 ==> object not saved in db
    public function __construct($id, $author, $title, $capacity, $pallets, $about, $add_date, $from_start_date, $from_end_date, $to_start_date, $to_end_date, $loc_start, $loc_end){
        
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->capacity = $capacity;
        $this->pallets = $pallets;
        $this->about = $about;
        $this->add_date = $add_date;
        $this->from_start_date = $from_start_date;
        $this->from_end_date = $from_end_date;
        $this->to_start_date = $to_start_date;
        $this->to_end_date = $to_end_date;
        $this->loc_start = $loc_start;
        $this->loc_end = $loc_end;
    }
    
     //saves parcel in db - false if failed
    public function sqlInsert(){
        global $host, $username, $password, $dbname, $options;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return false;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO vehicles(Author, Title, Capacity, Pallets, About, Add_date, F_start_date, F_end_date, T_start_date,  T_end_date, Loc_start, Loc_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
        
        $stmt->bind_param("isiissssssii", $this->author, $this->title, $this->capacity, $this->pallets, $this->about, $this->add_date, $this->from_start_date, $this->from_end_date, $this->to_start_date, $this->to_end_date, $this->loc_start->getId(), $this->loc_end->getId());
        $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            $this->id = $stmt->insert_id;
            return $this;
        }
            
        }
        else{
            print "Failed to prepare statement\n";
            return false;
        }
        $stmt->close();
        $conn->close();
    }
        return false;
    }
    
  	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

    public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}
    
	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getCapacity(){
		return $this->capacity;
	}

	public function setCapacity($capacity){
		$this->capacity = $capacity;
	}

	public function getPallets(){
		return $this->pallets;
	}

	public function setPallets($pallets){
		$this->pallets = $pallets;
	}

	public function getAbout(){
		return $this->about;
	}

	public function setAbout($about){
		$this->about = $about;
	}

	public function getAdd_date(){
		return $this->add_date;
	}

	public function setAdd_date($add_date){
		$this->add_date = $add_date;
	}

	public function getFrom_start_date(){
		return $this->from_start_date;
	}

	public function setFrom_start_date($from_start_date){
		$this->from_start_date = $from_start_date;
	}

	public function getFrom_end_date(){
		return $this->from_end_date;
	}

	public function setFrom_end_date($from_end_date){
		$this->from_end_date = $from_end_date;
	}

	public function getTo_start_date(){
		return $this->to_start_date;
	}

	public function setTo_start_date($to_start_date){
		$this->to_start_date = $to_start_date;
	}

	public function getTo_end_date(){
		return $this->to_end_date;
	}

	public function setTo_end_date($to_end_date){
		$this->to_end_date = $to_end_date;
	}

	public function getLoc_start(){
		return $this->loc_start;
	}

	public function setLoc_start($loc_start){
		$this->loc_start = $loc_start;
	}

	public function getLoc_end(){
		return $this->loc_end;
	}

	public function setLoc_end($loc_end){
		$this->loc_end = $loc_end;
	}  
    
}

class Parcel{
    private $id;
    private $author;
    private $category;
    private $title;
    private $length;
    private $width;
    private $height;
    private $weight;
    private $amount;
    private $about;
    private $add_date;
    private $from_start_date;
    private $from_end_date;
    private $to_start_date;
    private $to_end_date;
    private $loc_start;
    private $loc_end;
    
    //if id == -1 ==> object not saved in db
    public function __construct($id, $author, $category, $title, $length, $width, $height, $weight, $amount, $about, $add_date, $from_start_date, $from_end_date, $to_start_date, $to_end_date, $loc_start, $loc_end){
        
        $this->id = $id;
        $this->author = $author;
        $this->category = $category;
        $this->title = $title;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->weight = $weight;
        $this->amount = $amount;
        $this->about = $about;
        $this->add_date = $add_date;
        $this->from_start_date = $from_start_date;
        $this->from_end_date = $from_end_date;
        $this->to_start_date = $to_start_date;
        $this->to_end_date = $to_end_date;
        $this->loc_start = $loc_start;
        $this->loc_end = $loc_end;
    }
    
        //saves parcel in db - false if failed
    public function sqlInsert(){
        global $host, $username, $password, $dbname, $options;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return false;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO parcels(Author, Category, Title, Length, Width, Height, Weight, Amount, About, Add_date, F_start_date, F_end_date, T_start_date, T_end_date, Loc_start, Loc_end, Active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)")){
        
        $stmt->bind_param("issddddissssssii", $this->author, $this->category, $this->title, $this->length, $this->width, $this->height, $this->weight, $this->amount, $this->about, $this->add_date, $this->from_start_date, $this->from_end_date, $this->to_start_date, $this->to_end_date, $this->loc_start->getId(), $this->loc_end->getId());
        $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            $this->id = $stmt->insert_id;
            return $this;
        }
            
        }
        else{
            print "Failed to prepare statement\n";
            return false;
        }
        $stmt->close();
        $conn->close();
    }
        return false;
    }
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

    public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}
    
	public function getCategory(){
		return $this->category;
	}

	public function setCategory($category){
		$this->category = $category;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getLength(){
		return $this->length;
	}

	public function setLength($length){
		$this->length = $length;
	}

	public function getWidth(){
		return $this->width;
	}

	public function setWidth($width){
		$this->width = $width;
	}

	public function getHeight(){
		return $this->height;
	}

	public function setHeight($height){
		$this->height = $height;
	}

	public function getWeight(){
		return $this->weight;
	}

	public function setWeight($weight){
		$this->weight = $weight;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function setAmount($amount){
		$this->amount = $amount;
	}

	public function getAbout(){
		return $this->about;
	}

	public function setAbout($about){
		$this->about = $about;
	}

	public function getAdd_date(){
		return $this->add_date;
	}

	public function setAdd_date($add_date){
		$this->add_date = $add_date;
	}

	public function getFrom_start_date(){
		return $this->from_start_date;
	}

	public function setFrom_start_date($from_start_date){
		$this->from_start_date = $from_start_date;
	}

	public function getFrom_end_date(){
		return $this->from_end_date;
	}

	public function setFrom_end_date($from_end_date){
		$this->from_end_date = $from_end_date;
	}

	public function getTo_start_date(){
		return $this->to_start_date;
	}

	public function setTo_start_date($to_start_date){
		$this->to_start_date = $to_start_date;
	}

	public function getTo_end_date(){
		return $this->to_end_date;
	}

	public function setTo_end_date($to_end_date){
		$this->to_end_date = $to_end_date;
	}

	public function getLoc_start(){
		return $this->loc_start;
	}

	public function setLoc_start($loc_start){
		$this->loc_start = $loc_start;
	}

	public function getLoc_end(){
		return $this->loc_end;
	}

	public function setLoc_end($loc_end){
		$this->loc_end = $loc_end;
	}
    
}

class Location{
    private $id;
    private $country;
    private $province;
    private $city;
    private $street;
    private $nr;
    private $postcode;
    
    //if id == -1 ==> object not saved in db
    public function __construct($id, $country, $province, $city, $street, $nr, $postcode){
        $this->id = $id;
        $this->country = $country;
        $this->province = $province;
        $this->city = $city;
        $this->street = $street;
        $this->nr = $nr;
        $this->postcode = $postcode;
    }
    
    //saves location in db - false if failed
    public function sqlInsert(){
        global $host, $username, $password, $dbname, $options;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return false;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO locs(Country, Province, City, Street, Nr, Postcode) VALUES (?, ?, ?, ?, ?, ?)")){
             
        $stmt->bind_param("ssssis", $this->country, $this->province, $this->city, $this->street, $this->nr, $this->postcode);
        $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            $this->id = $stmt->insert_id;
            return $this;
        }
            
            
        }
        else{
            print "Failed to prepare statement\n";
            return false;
        }
        $stmt->close();
        $conn->close();
    }
        return false;
    }

	public function getCountry(){
		return $this->country;
	}

	public function setCountry($country){
		$this->country = $country;
	}
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getProvince(){
		return $this->province;
	}

	public function setProvince($province){
		$this->province = $province;
	}

	public function getCity(){
		return $this->city;
	}

	public function setCity($city){
		$this->city = $city;
	}

	public function getStreet(){
		return $this->street;
	}

	public function setStreet($street){
		$this->street = $street;
	}

	public function getNr(){
		return $this->nr;
	}

	public function setNr($nr){
		$this->nr = $nr;
	}

	public function getPostcode(){
		return $this->postcode;
	}

	public function setPostcode($postcode){
		$this->postcode = $postcode;
	}
}


class Offer{
    
    private $id;
    private $for_id;
    private $author;
    private $price;
    private $add_date;
    private $loading_f;
    private $loading_t;
    private $transport_time;
    private $transport_type;
    private $about;
    
    //if id == -1 ==> object not saved in db
    public function __construct($id, $for_id, $author, $price, $add_date, $loading_f, $loading_t, $transport_time, $transport_type, $about){
        $this->id = $id;
        $this->for_id = $for_id;
        $this->author = $author;
        $this->price = $price;
        $this->add_date = $add_date;
        $this->loading_f = $loading_f;
        $this->loading_t = $loading_t;
        $this->transport_time = $transport_time;
        $this->transport_type = $transport_type;
        $this->about = $about;
    }
    
    //saves offer in db - false if failed
    public function sqlInsert(){
        global $host, $username, $password, $dbname, $options;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return false;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO offers(For_id, Author, Price, Add_date, Loading_f, Loading_t, Transport_time, Transport_type, About) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")){
             
        $stmt->bind_param("iidssssss", $this->for_id, $this->author, $this->price, $this->add_date, $this->loading_f, $this->loading_t, $this->transport_time, $this->transport_type, $this->about);
        $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            $this->id = $stmt->insert_id;
            return $this;
        }
            
            
        }
        else{
            print "Failed to prepare statement\n";
            return false;
        }
        $stmt->close();
        $conn->close();
    }
        return false;
    }
    
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getFor_id(){
		return $this->for_id;
	}

	public function setFor_id($for_id){
		$this->for_id = $for_id;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
	}

	public function getAdd_date(){
		return $this->add_date;
	}

	public function setAdd_date($add_date){
		$this->add_date = $add_date;
	}

	public function getLoading_f(){
		return $this->loading_f;
	}

	public function setLoading_f($loading_f){
		$this->loading_f = $loading_f;
	}

	public function getLoading_t(){
		return $this->loading_t;
	}

	public function setLoading_t($loading_t){
		$this->loading_t = $loading_t;
	}

	public function getTransport_time(){
		return $this->transport_time;
	}

	public function setTransport_time($transport_time){
		$this->transport_time = $transport_time;
	}

	public function getTransport_type(){
		return $this->transport_type;
	}

	public function setTransport_type($transport_type){
		$this->transport_type = $transport_type;
	}

	public function getAbout(){
		return $this->about;
	}

	public function setAbout($about){
		$this->about = $about;
	}
    
}

class Comment{
    private $id;
    private $offer_type;
    private $offer_id;
    private $author;
    private $add_date;
    private $content;
    
    public function __construct($id, $offer_type, $offer_id, $author, $add_date, $content){
        $this->id = $id;
        $this->offer_type = $offer_type;
        $this->offer_id = $offer_id;
        $this->author = $author;
        $this->add_date = $add_date;
        $this->content = $content;
    }
    
    //saves offer in db - false if failed
    public function sqlInsert(){
        global $host, $username, $password, $dbname, $options;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return false;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO comments(Offer_type, Offer_id, Author, Add_date, Comment) VALUES (?, ?, ?, ?, ?)")){
             
        $stmt->bind_param("siiss", $this->offer_type, $this->offer_id, $this->author, $this->add_date, $this->content);
        $stmt->execute();
            
        if($stmt->affected_rows != 1){
            error_log($stmt->error, 0);
            return false;
        }
        else{
            $this->id = $stmt->insert_id;
            return $this;
        }
            
            
        }
        else{
            print "Failed to prepare statement\n";
            return false;
        }
        $stmt->close();
        $conn->close();
    }
        return false;
    }
    
    
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getOffer_type(){
		return $this->offer_type;
	}

	public function setOffer_type($offer_type){
		$this->offer_type = $offer_type;
	}

	public function getOffer_id(){
		return $this->offer_id;
	}

	public function setOffer_id($offer_id){
		$this->offer_id = $offer_id;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getAdd_date(){
		return $this->add_date;
	}

	public function setAdd_date($add_date){
		$this->add_date = $add_date;
	}

	public function getContent(){
		return $this->content;
	}

	public function setContent($content){
		$this->content = $content;
	}
    
}

class VehicleOffer{
    
    private $id;
    private $for_id;
    private $author;
    private $price;
    private $add_date;
    private $loading_f;
    private $loading_t;
    private $weight;
    private $length;
    private $height;
    private $width;
    private $about;
    
    //if id == -1 ==> object not saved in db
    public function __construct($id, $for_id, $author, $price, $add_date, $loading_f, $loading_t, $weight, $length, $height, $width, $about){
        $this->id = $id;
        $this->for_id = $for_id;
        $this->author = $author;
        $this->price = $price;
        $this->add_date = $add_date;
        $this->loading_f = $loading_f;
        $this->loading_t = $loading_t;
        $this->weight = $weight;
        $this->length = $length;
        $this->height = $height;
        $this->width = $width;
        $this->about = $about;
    }
    
    //saves offer in db - false if failed
    public function sqlInsert(){
        global $host, $username, $password, $dbname, $options;
        
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if ($conn->connect_errno!=0){
		return false;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("INSERT INTO vehicle_offers(For_id, Author, Price, Add_date, Loading_f, Loading_t, Weight, Length, Height, Width, About) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")){
             
        $stmt->bind_param("iidsssdddds", $this->for_id, $this->author, $this->price, $this->add_date, $this->loading_f, $this->loading_t, $this->weight, $this->length, $this->height, $this->width, $this->about);
        $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            $this->id = $stmt->insert_id;
            return $this;
        }
            
            
        }
        else{
            print "Failed to prepare statement\n";
            return false;
        }
        $stmt->close();
        $conn->close();
    }
        return false;
    }
    
    
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getFor_id(){
		return $this->for_id;
	}

	public function setFor_id($for_id){
		$this->for_id = $for_id;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
	}

	public function getAdd_date(){
		return $this->add_date;
	}

	public function setAdd_date($add_date){
		$this->add_date = $add_date;
	}

	public function getLoading_f(){
		return $this->loading_f;
	}

	public function setLoading_f($loading_f){
		$this->loading_f = $loading_f;
	}

	public function getLoading_t(){
		return $this->loading_t;
	}

	public function setLoading_t($loading_t){
		$this->loading_t = $loading_t;
	}

	public function getWeight(){
		return $this->weight;
	}

	public function setWeight($weight){
		$this->weight = $weight;
	}

	public function getLength(){
		return $this->length;
	}

	public function setLength($length){
		$this->length = $length;
	}

	public function getHeight(){
		return $this->height;
	}

	public function setHeight($height){
		$this->height = $height;
	}

	public function getWidth(){
		return $this->width;
	}

	public function setWidth($width){
		$this->width = $width;
	}

	public function getAbout(){
		return $this->about;
	}

	public function setAbout($about){
		$this->about = $about;
	}
   
}


class Profile{
    private $id;
    private $name;
    private $register_date;
    private $email;
    private $tel;
    private $payment_methods;
    private $scope_delivery;
    private $nip;
    private $company_name;
    private $invoices;
    private $positive;
    private $neutral;
    private $negative;
    
    
    public function __construct($id, $name, $register_date, $email, $tel, $payment_methods, $scope_delivery, $nip, $company_name, $invoices, $positive, $neutral, $negative){
        $this->id = $id;
        $this->name = $name;
        $this->register_date = $register_date;
        $this->email = $email;
        $this->tel = $tel;
        $this->payment_methods = $payment_methods;
        $this->scope_delivery = $scope_delivery;
        $this->nip = $nip;
        $this->company_name = $company_name;
        $this->invoices = $invoices;
        $this->positive = $positive;
        $this->neutral = $neutral;
        $this->negative = $negative;
    }
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}
    
    public function getRegister_date(){
		return $this->register_date;
	}

	public function setRegister_date($date){
		$this->register_date = $date;
	}

	public function getTel(){
		return $this->tel;
	}

	public function setTel($tel){
		$this->tel = $tel;
	}

	public function getPayment_methods(){
		return $this->payment_methods;
	}

	public function setPayment_methods($payment_methods){
		$this->payment_methods = $payment_methods;
	}

	public function getScope_delivery(){
		return $this->scope_delivery;
	}

	public function setScope_delivery($scope_delivery){
		$this->scope_delivery = $scope_delivery;
	}

	public function getNip(){
		return $this->nip;
	}

	public function setNip($nip){
		$this->nip = $nip;
	}

	public function getCompany_name(){
		return $this->company_name;
	}

	public function setCompany_name($company_name){
		$this->company_name = $company_name;
	}

	public function getInvoices(){
		return $this->invoices;
	}

	public function setInvoices($invoices){
		$this->invoices = $invoices;
	}

	public function getPositive(){
		return $this->positive;
	}

	public function setPositive($positive){
		$this->positive = $positive;
	}

	public function getNeutral(){
		return $this->neutral;
	}

	public function setNeutral($neutral){
		$this->neutral = $neutral;
	}

	public function getNegative(){
		return $this->negative;
	}

	public function setNegative($negative){
		$this->negative = $negative;
	}
    
}


class Opinion{
    private $id;
    private $type;
    private $add_date;
    private $author;
    private $opinion_for;
    private $opinion;
    
    public function __construct($id, $type, $add_date, $author, $opinion_for, $opinion){
        $this->id = $id;
        $this->type = $type;
        $this->add_date = $add_date;
        $this->author = $author;
        $this->opinion_for = $opinion_for;
        $this->opinion = $opinion;
    }
    
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function getAdd_date(){
		return $this->add_date;
	}

	public function setAdd_date($add_date){
		$this->add_date = $add_date;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getOpinion_for(){
		return $this->opinion_for;
	}

	public function setOpinion_for($opinion_for){
		$this->opinion_for = $opinion_for;
	}

	public function getOpinion(){
		return $this->opinion;
	}

	public function setOpinion($opinion){
		$this->opinion = $opinion;
	}
    
}


?>