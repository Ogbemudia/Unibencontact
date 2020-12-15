<?php

require_once('session.php');
login();            

require_once('configdb.php');





        
$missingCategory1 = $status=$category1=$mailbox=$checkMail=$checkMail1=$errors=$resultMessages=$errormsg="";
$missingCategory1 = 'Please select the category you are forwarding to!';
$missingMailbox = 'Please check the message you want to forward!';
$errormsg = 'Please select message and category!';


if(isset($_POST["apply"]) && isset($_POST['mail']) && trim($_POST["category1"]!='1')){
  
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
          header("Location: messagedb.php?page_no=$page_no&category=$category");
            exit;
            
            }
            
            }
            
    }elseif(isset($_POST["apply"]) && isset($_POST['mail']) && trim($_POST['status']!='1')){
      $status= $_POST['status'];
      $status = filter_var($status, FILTER_SANITIZE_STRING);
      $page_no=$_GET['page_no'];
     $mailbox=$_POST['mail']; 
     foreach($mailbox as $checkMail) :  
       $checkMail1 .= $checkMail.",";  
        //echo $checkMail1;
     endforeach;
       $checkMail1=rtrim($checkMail1, ",");
       // echo $checkMail1;
    
    
   $sql = "UPDATE contact_us SET action = '$status' WHERE id IN ($checkMail1)";

    if(mysqli_query($link, $sql)) {
      mysqli_close($link); 

     header("Location: messagedb.php?page_no=$page_no&category=$category");
      exit;
   
    }
  }
  

?>