<?php
require_once('session.php');
login();
require_once('configdb.php');

//echo 'ok';
$id = $_GET['button'];
//echo $category = $_GET['category'];


        $sql = "DELETE FROM login WHERE id = '$id'";

        if(mysqli_query($link, $sql)) {
            mysqli_close($link);
            header('Location: admin.php');
            exit;
            }else{
               // echo "<p>Unable to delete record</p>";
            }
            
    
?>