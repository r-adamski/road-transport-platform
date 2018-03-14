<?php
include_once "cfg.php";


function isEmailUsed($email){
    global $host, $username, $password, $dbname;
    $conn = new mysqli($host, $username, $password, $dbname);
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM users WHERE Email = ?")){
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows == 0){
                return false;
            }
        }
    }
    
    return true;
}

function isPhoneUsed($phone){
    global $host, $username, $password, $dbname;
    $conn = new mysqli($host, $username, $password, $dbname);
	if ($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("SELECT * FROM users WHERE Tel = ?")){
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows == 0){
                return false;
            }
        }
    }
    
    return true;
}

?>
