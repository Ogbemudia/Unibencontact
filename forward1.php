<?php

require_once('session.php');
login();            

require_once('configdb.php');





        
$missingCategory1 = $category1=$mailbox=$checkMail=$checkMail1=$errors=$resultMessages=$errormsg="";
$missingCategory1 = 'Please select the category you are forwarding to!';
$missingMailbox = 'Please check the message you want to forward!';
$errormsg = 'Please select message and category!';


if(isset($_POST["apply"]) && isset($_POST['mail']) && isset($_POST['category1'])){
    $page_no=$_GET['page_no'];
    $mailbox=$_POST['mail']; 
   $category1= $_POST['category1'];
    
    if(!$mailbox){
        $errors .= $missingMailbox;
    }
    if(!$category1){
        $errors .= $missingCategory1;
    }else{
       $category1 = filter_var($category1, FILTER_SANITIZE_STRING);
    }
    if($errors){
        //print error message
        $resultMessages = "<div class='alert alert-danger'>$errors</div>";
    }else{
        
    foreach($mailbox as $checkMail) :  
            $checkMail1 .= $checkMail.",";  
            //echo $checkMail1;
    endforeach;
            $checkMail1=rtrim($checkMail1, ",");
           // echo $checkMail1;
        
        
       $sql = "UPDATE contact_us SET categories = '$category1' WHERE id IN ($checkMail1)";

        if(mysqli_query($link, $sql)) {
            mysqli_close($link);
            
            //echo "<p> add comment</p>";
           header("Location: registry.php?page_no=$page_no");
            exit;
            }else{
                echo "<p>Unable to add comment</p>";
               
            }
    }}else{
        $errors .=$errormsg;
       // $resultMessages = "<div class='alert alert-danger'>$errors</div>";
    }
//}
?>