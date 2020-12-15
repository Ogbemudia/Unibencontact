<?php
require_once('session.php');
login();

$username = $_SESSION['userlogin'];
$category = $_SESSION['categories'];
$id = $_SESSION["id"];
require_once('configdb.php');
?>

<?php

  $result_count = mysqli_query($link,"SELECT COUNT(id) As total_mails FROM `contact_us` WHERE categories='$category'");
  $total_records = mysqli_fetch_array($result_count);
  $total_records = $total_records['total_mails'];
  
  $result_count_unread = mysqli_query($link,"SELECT COUNT(*) As total_unread FROM `contact_us` WHERE action='Unread' AND categories='$category'");
  $total_unread = mysqli_fetch_array($result_count_unread);
  $total_unread = $total_unread['total_unread'];
  
  //echo $total_unread."and".$total_records;


?>    

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>document.getElementsByTagName("html")[0].className += " js";</script>
  <link rel="stylesheet" href="asset/css/style.css">
  <title>Admin | Uniben</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/2ff0eac90c.js"></script>
  <style>
    a:hover{
      text-decoration: none;
    }
    .cd-side__sub-item a{
      
      transition-property: font-weight;
     
      transition-timing-function: ease;
      
    }
    .cd-side__sub-item a:hover{
      font-weight: bolder;
    }
  </style>
  <body>
  <header class="cd-main-header js-cd-main-header" style="font-size:20px">
    <div class="cd-logo-wrapper">
      <a href="https://uniben.edu" target="blank" title="Uniben Home Page" class="cd-logo"><img src="assets/img/logo2.png" alt="Uniben Logo" style="height: 60px; width:80px"></a>
    </div>
    
    <div class="cd-search js-cd-search">
      <form>
        <input class="reset" type="search" placeholder="Search...">
      </form>
    </div>
  
    <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>
  
    <ul class="cd-nav__list js-cd-nav__list">
      <li class="cd-nav__item"><a href="https://uniben.edu" target="blank"><h2 style="color:#fff;">Uniben</h2></a></li>
      <!--<li class="cd-nav__item"><a href="#0">Support</a></li>-->
      <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">
        <a href="#0">
          <!--<img src="asset/img/cd-avatar.svg" alt="avatar">-->
          <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
          <span>Account</span>
        </a>
    
        <ul class="cd-nav__sub-list">
          <!--<li class="cd-nav__sub-item"><a href="#0">My Account</a></li>-->
          <li class="cd-nav__sub-item"><a href="changepass.php">Change password</a></li>
          <li class="cd-nav__sub-item"><a href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </header> <!-- .cd-main-header -->
  
  <main class="cd-main-content">
    <nav class="cd-side-nav js-cd-side-nav" style="font-size:20px">
      <ul class="cd-side__list js-cd-side__list">
        <li class="cd-side__label"><span>All Notifications</span></li>
        <!--<li class="cd-side__sub-item">All Notifications</li>-->

        <li class="cd-side__item cd-side__item--has-children cd-side__item--notifications cd-side__item--selected js-cd-item--has-children">
         <a style="font-size:15px;">Unread Mails<span class="cd-count"><?php echo $total_unread; ?></span></a>
         <a style="font-size:15px;">Total Mails<span class="cd-count" style="background-color: #3E9230;"><?php echo $total_records; ?></span></a>
            <ul class="cd-side__sub-list">
            <!--<li class="cd-side__sub-item"><a aria-current="page" href="#0">All Notifications</a></li>-->
           <!-- <li class="cd-side__sub-item"><a href="#0">Total Mails: <?php //echo $total_unread; ?></a></li>
            <li class="cd-side__sub-item"><a href="#0">Other</a></li>-->
          </ul>
        </li>
    
        <!--<li class="cd-side__item cd-side__item--has-children cd-side__item--comments js-cd-item--has-children">-->
        
        <ul class="cd-side__sub-item">
            
          </ul>
          
      
    </nav>
  
    <div class="cd-content-wrapper">
    <div class="text-component text-center" style='text-align:left;'>
      <h1 style="text-transform: capitalize;"><?php echo $category ?> Mails</h1>

        <div class="">
        <?php
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
        <div>".$action."</div>
              <div style='position:relative;'><div>".$sender."</div>
              <div style='float:right;'>".$date."</div>
              
              <div>".$subject."</div>
	 		  <div>".substr($row['message'],0,150)."...</div>
              
              <div>".$row['comments']."</div>
              <div style='position:relative;'><div style='float:right;'> <a href='treat.php?button=" . $row["id"] . "&page_no=" .$page_no . "&username=" .$username. "'><button type='button' class='btn btn-primary'>Message replied</button></a> </div>
              <div style='float:right; margin-right:10px;'> <a href='view.php?button=" . $row["id"]."&page_no=" .$page_no . "'><button type='button' value='button2' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span>View message</button></a> </div>   
              

              </div></br><hr>";
              
        
            }
	mysqli_close($link);
    ?>
    
            
           
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
    </div> <!-- .content-wrapper -->
  </main> <!-- .cd-main-content -->
  <script src="asset/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
  <script src="asset/js/menu-aim.js"></script>
  <script src="asset/js/main.js"></script>
</body>
</html>