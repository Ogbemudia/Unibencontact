<?php
session_start();

//echo $_SESSION['userlogin'];

if(isset($_SESSION['loggedin'])){
    unset($_SESSION['loggedin']);  //Destroy This Session
   // $_SESSION = [];
//redirect to login page
header("location: login.php");
}
?>