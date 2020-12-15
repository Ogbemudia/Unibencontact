<?php
require_once('session.php');
login();
$category = $_SESSION['categories'];
 if($category=='admin'){
    header("location: admin.php");
} else if($category=='registry'){
    header("location: registry.php");
}else if($category=='bursary'){
    header("location: usersmsg.php");
}else if($category=='ICT/CRPU'){
    header("location: usersmsg.php");
}else if($category=='servicon'){
    header("location: usersmsg.php");
}else if($category=='transcript'){
    header("location: usersmsg.php");
}else if($category=='student affairs'){
    header("location: usersmsg.php");
}else if($category=='others'){
    header("location: usersmsg.php");
}  
?>