<?php

session_start();
include_once "functions.php";
$error = [];
$error['comment_empty'] = false;
$error['adding_failed'] = false;
    
$execute = true;
if($_SESSION['logged'] == true && isset($_POST['offer_id'], $_POST['offer_type'], $_POST['comment'])){
    
    if($_POST['comment'] === ''){
        $error['comment_empty'] = true;
        $execute = false;
    }
    
    
    if($execute){
        $add_time = date('Y-m-d H:i:s');
        
        $comment = new Comment(-1, $_POST['offer_type'], $_POST['offer_id'], $_SESSION['id'], $add_time, $_POST['comment']);
        
        $comment_new = $comment->sqlInsert();
            if($comment_new != false){
                 //added succesfully
                error_log("tralal", 0);
            }
            else{
                $error['adding_failed'] = true;\
                    error_log("dupa", 0);
            }
        
    }
    
}

header('Content-Type: application/json');
echo json_encode($error);

?>
