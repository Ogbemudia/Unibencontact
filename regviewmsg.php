
<?php
require_once('session.php');
login();
if($_SESSION['categories'] !== 'registry'){
  header("location: logout.php");
  exit;
}
require_once('configdb.php');
$action ="";

if(!isset($_GET['button']))

 echo '</br>';
 $page_no= $_GET['page_no']
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | UniBEN</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>  <script src="https://use.fontawesome.com/2ff0eac90c.js"></script>



    <style>
     
        #site-logo {
            width: 140px;
            height: 100px;
        }

        .site-logo-image {
            width: 100%;
            height: 100%;
        }
        

        h1{
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
        .right{
          margin-left: 80px;
          text-align: left;
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

        .th1{
          width: 50px;
        }

  </style>

</head>
<body>
    <div class="page">
        <header>
            <div id="site-logo">
                <a href="../index.html" target="blank" title="Uniben Home Page"><img src="assets/img/logo2.png" alt="Uniben Logo" class="site-logo-image" /></a>
            </div>
            

            

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="../index.html" target="blank" >Uniben</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="messagedb.php" target="blank" style="color: #fff;">Admin <span class="sr-only">(current)</span></a>
      </li>
      
     <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>-->
    </ul>
    
    <ul class="navbar-nav  my-2 my-lg-0">
    <li class="nav-item">
        <a class="nav-link" href="logout.php" style="color: #fff;">Sign out</a>
      </li>
      </ul>
      
    
    
  </div>
</nav>
        </header>
        

        <?php
if(isset($_GET['button'])){
        
$id = $_GET['button'];



  
  

        $sql = "SELECT name, date, email, subject, message, categories FROM contact_us WHERE id = $id";
        $result = $link->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
        $comment = "Please respond to this mail.";
        $sender = $row['name'];
        $date = $row['date'];
        $email = $row['email'];
        $subject = $row['subject'];
        $message = $row['message'];
        $category = $row['categories'];
        
  } 
    }else{
      echo "No message is available.";
    }}
           
?>
        
        
        <div class="container">
        <div class="row">

            <div class="col-sm-offset-1 col-12 contactForm" id="msg1">
            <a href='regview.php?page_no=<?php echo $page_no; ?>&category=<?php echo $category;?>' class='btn btn-primary'><i class='fa fa-undo' aria-hidden='true'></i>Back to messages</a>
            
           
                
    <div class="sender" style="display: flex;">
          <div class=""><b>Sender:</b></div>
          <div class="right"><?php echo $sender?></div>
    </div>
    <div class="sender" style="display: flex;">
          <div class=""><b>Email:</b></div>
          <div class="right"><?php echo $email?></div>
    </div>  
    <div class="sender" style="display: flex;">
          <div class=""><b>Date:</b></div>
          <div class="right"><?php echo $date?></div>
    </div>
    <br>  
    <div class="sender">
          <div class=""><b>Message</b></div>
          <div class=""><?php echo $message?></div>
    </div>
    <a href='mailto:<?php $email ?>'><button type='button' class='btn btn-primary'><i class='fa fa-mail-reply' aria-hidden='true'></i>Reply Mail</button></a> 
    
  </div>
          
           <?php
           //echo $msg;
           ?>




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