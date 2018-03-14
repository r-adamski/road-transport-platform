<?php
include_once "cfg.php";

function editComment($id, $content){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        
        //delete if empty comment input
        if($content === ""){
            if($stmt->prepare("DELETE FROM `comments` WHERE `Id`= ?")){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            return true;
        }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        }
        else{
        //update
        if($stmt->prepare("UPDATE `comments` SET `Comment` = ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $content, $id);
            $stmt->execute();
            
        if($stmt->affected_rows != 1){
            return false;
        }
        else{
            return true;
        }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        }
        
        
        
        $stmt->close();
        $conn->close();
    }
    return false;
}

function setUsersSql($id, $toset, $row){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `".$row."` = ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $toset, $id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}



function setEmail($id, $email){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `Email`= ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $email, $id);
            $stmt->execute();
            
            //mail confirmation
            if($stmt->affected_rows == 1){
                $stmt1 = $conn->stmt_init();
                if($stmt1->prepare("UPDATE `users` SET `Email_confirmed`= 0 WHERE `Id`= ?")){
                    $stmt1->bind_param("i", $id);
                    $stmt1->execute();
                }
                else{
                    print "Failed to prepare statement1\n";
                }
            }
            
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}

function setEmailConfirmed($id){
    global $host, $username, $password, $dbname, $options;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `Email_confirmed`='confirmed' WHERE `Id`= ?")){
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

function setPass($id, $pass){
    global $host, $username, $password, $dbname, $options;
    
    $hash = password_hash($pass, PASSWORD_BCRYPT, $options);
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `Password`= ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $hash, $id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}


/*
function setTel($id, $tel){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `Tel`= ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $tel, $id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}


function setPayment($id, $payment){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `Payment_methods`= ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $payment, $id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}


function setScope($id, $scope){
    global $host, $username, $password, $dbname;
    
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
	if($conn->connect_errno!=0){
		return "Error: ".$conn->connect_errno;
	}
	else{
        $stmt = $conn->stmt_init();
        if($stmt->prepare("UPDATE `users` SET `Scope_delivery`= ? WHERE `Id`= ?")){
            $stmt->bind_param("si", $scope, $id);
            $stmt->execute();
        }
        else{
            print "Failed to prepare statement\n";
        }
        $stmt->close();
        $conn->close();
    }
}
*/




?>
