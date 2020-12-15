<?php


session_start();

function login(){
//Initializing the session


if (!isset($_SESSION['loggedin'])) {
    
    //redirect to login page
header("location: login.php");
   
}
else {
    $now = time(); // Checking the time now when home page starts.

    if ($now > $_SESSION['expire']) {
        session_destroy();
       header("location: login.php");
       exit;
    }}
}
    ?>