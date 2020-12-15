<?php
require_once('session.php');
login();
require_once('configdb.php');

?>


<?php
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
        }

$id = $_GET['button'];

        $sql = "DELETE FROM contact_us WHERE id = $id";

        if(mysqli_query($link, $sql)) {
            mysqli_close($link);
            header('Location: messagedb.php?page_no=' . $page_no);
            exit;
            }else{
                //echo "<p>Unable to delete record</p>";
            }
            
    
?>