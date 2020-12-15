
<?php
require_once('session.php');
login();

$username = $_SESSION['userlogin'];
$category = $_SESSION['categories'];
$id = $_SESSION["id"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | UniBEN</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/2ff0eac90c.js"></script>



    <style>
        #site-logo {
            width: 140px;
            height: 100px;
        }

        .site-logo-image {
            width: 100%;
            height: 100%;
        }
        

        h1, h3{
            color:purple;
        }
        
        
        .contactForm{
            /*border: 1px solid #9C0C84;*/
            margin-top: 50px;
            border-radius: 15px;
            margin-bottom: 60px;
            /*width: 60%;
            padding: 20px*/
        }

        footer{
            
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

        .sub-footer {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-evenly;
            background-color: rgb(77, 7, 65);
            /*margin-top: -26px;*/
            padding-top: 6px;
            padding-bottom: 8px;
            color: #F3F3F3;
            width: 100%;
        }

        .sub-footer-left {
            padding-left: 15px; text-align: left; width:48%;
        }

        .sub-footer-right {
            text-align: right; width:48%;
        }
    </style>

</head>
<body>
    <div class="page">
        <header>
            <div id="site-logo">
                <a href="../index.html" target="blank" title="Uniben Home Page"><img src="assets/img/logo2.png" alt="Uniben Logo" class="site-logo-image" /></a>
            </div>
            

            <nav class="navbar navbar-default" style="background-color:#9C0C84;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="../index.html" target="blank" style="color: #fff; font-size: 40px;">Uniben</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active">  </li>
      
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="messagedb.php" target="blank" style="color: #fff;"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
      <li><a href="logout.php" style="color: #fff;"><span class="glyphicon glyphicon-log-in"></span> Sign out</a></li>
    </ul>
  </div>
</nav>
  </div>
</nav>
        </header>
        
        
        <div class="container">
        <div class="row">
            <div class="col-sm-offset-1 col-12 contactForm">
            <h1 style="text-transform: capitalize;"><?php echo $category ?> Mails</h1>
            <div style="overflow-x: auto;">
                
            <div>
            <?php
    
    ?>
<?php
$action ="";


//connect to our database.
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'contact');
$link = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//checking connection
if(mysqli_connect_errno() > 0){
die("Error: unable to connect: ". mysqli_connect_errno());
}else{
   // echo "<p>Connection to database is successful</p>";
}

if (isset($_GET['page_no']) && $_GET['page_no']!="") {
	$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
        }

	$total_records_per_page = 30;
    $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($link,"SELECT COUNT(*) As total_records FROM `contact_us` WHERE categories='$category'");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total page minus 1

    //number of unread messages
    $result_count_unread = mysqli_query($link,"SELECT COUNT(*) As total_unread FROM `contact_us` WHERE categories='$category'AND action='Unread'");
    $total_unread = mysqli_fetch_array($result_count_unread);
    $total_unread = $total_unread['total_unread'];
    echo "<div></div><h3>Total Mail: $total_records | Unread: $total_unread</h3></div>";

    $result = mysqli_query($link,"SELECT * FROM `contact_us` WHERE categories='$category' ORDER BY id DESC LIMIT $offset, $total_records_per_page");
    while($row = mysqli_fetch_array($result)){

        if($row['action']=='Read'){
            $action = "<div class='btn-success'style='width:40px'><i>".$row['action']."</i></div>";
            $sender = "<div>".$row['name']."</div>";
            $date = "<div>".$row['date']."</div>";
            //$total = "<div>".$row['email']."</div>";
            $subject = "<div>".$row['subject']."</div>";
        }else{
            $action = "<div class='btn-danger' style='width:50px'><i>".$row['action']."</i></div>";
            $sender = "<div><b>".$row['name']."</b></div>";
            $date = "<div><b>".$row['date']."</b></div>";
           // $email = "<div><b>".$row['email']."</b></div>";
            $subject = "<div><b>".$row['subject']."</b></div>";
        }
		echo "<div>
              <div style='margin-left:30px;'>".$action."</div>
              <div style='position:relative;'><div>".$sender."</div>
              <div style='float:right;'>".$date."</div>
              
              <div>".$subject."</div>
	 		  <div>".substr($row['message'],0,150)."...</div>
              
              <div>".$row['comments']."</div>
              <div style='position:relative;'><div style='float:right;'> <a href='treat.php?button=" . $row["id"] . "&page_no=" .$page_no . "'><button type='button' class='btn btn-primary'>Message replied</button></a> </div>
              <div style='float:right; margin-right:10px;'> <a href='view.php?button=" . $row["id"]."&page_no=" .$page_no . "'><button type='button' value='button2' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span>View message</button></a> </div>   
              </div>

              </div></br><hr>";
              
        
            }
	mysqli_close($link);
    ?>
    
            </div>
            </div>
<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
</div>

<ul class="pagination">
	<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
    
	<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
	</li>
       
    <?php 
	if ($total_no_of_pages <= 10){  	 
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
	}
	elseif($total_no_of_pages > 10){
		
	if($page_no <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}
        }
		echo "<li><a>...</a></li>";
		echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
		}

	 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
           if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                  
       }
       echo "<li><a>...</a></li>";
	   echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
	   echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
		
		else {
        echo "<li><a href='?page_no=1'>1</a></li>";
		echo "<li><a href='?page_no=2'>2</a></li>";
        echo "<li><a>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
          if ($counter == $page_no) {
		   echo "<li class='active'><a>$counter</a></li>";	
				}else{
           echo "<li><a href='?page_no=$counter'>$counter</a></li>";
				}                   
                }
            }
	}
?>
    
	<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
	<a <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
	</li>
    <?php if($page_no < $total_no_of_pages){
		echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
		} ?>
</ul>

            
        </div>
    </div>
    
    
        </div>
            
        </main>
        <footer>
        <div class="sub-footer">
            <div class="sub-footer-left">Copyright &copy; 2020, University of Benin</div>
            <div class="sub-footer-right">Designed by University of Benin, Web Unit, ICTU</div>
        </div>
            
        </footer>
        
    </div>
    
</body>
</html>