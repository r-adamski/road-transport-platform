<?php

session_start();
include_once "functions.php";
$error = [];
$error['comment_empty'] = false;
$error['adding_failed'] = false;
$execute = true;
if($_SESSION['logged'] == true && isset($_POST['comment_id'], $_POST['comment'])){
    if($_SESSION['id'] == getComment($_POST['comment_id'])->getAuthor()){
        
//    if($_POST['comment'] === ""){
//        $error['comment_empty'] = true;
//        $execute = false;
//    }
    
    
    if($execute){
        $success = editComment($_POST['comment_id'], $_POST['comment']);
            if($success != false){
                 //added succesfully
                //error_log("tralal", 0);
            }
            else{
                $error['adding_failed'] = true;
                  //  error_log("dupa", 0);
            }
        
    }
    }
}

header('Content-Type: application/json');
echo json_encode($error);

?>
