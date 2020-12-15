<?php
require_once('session.php');
login();

$username = $_SESSION['userlogin'];
$category = $_SESSION['categories'];
$id = $_SESSION["id"];
require_once('configdb.php');
?>

<?php
   $action ="";
//defining and initializing variables

$password = "";
$confirm_password = "";
$password_err = "";
$confirm_password_err = "";
$old_password=$old_password_err = "";


//processing data from login form
if($_SERVER["REQUEST_METHOD"] == "POST"){
   

  
    $username = trim($_SESSION['userlogin']);


//checking if password is empty
if(empty(trim($_POST["old_password"]))){
    $old_password_err = "Please enter your old password.";
}else{
    $old_password = trim($_POST["old_password"]);
}

//Validating inputs
if(empty($username_err) && empty($old_password_err)){
    
    //Select statement
    $sql = "SELECT id, username, pass, categories FROM login WHERE username =? AND categories=?";
    if($stmt = mysqli_prepare($link, $sql)){
        //bind the variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $category);
        
       //set parameters
       $param_username = $username;
       $param_Category = $category;
       
        //executing the statement
        if(mysqli_stmt_execute($stmt)){
            //store result
            mysqli_stmt_store_result($stmt);

            //checking if username exits, if yes verified password
            if(mysqli_stmt_num_rows($stmt) > 0){
                
                //Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_old_password, $category);
               
                
                if(mysqli_stmt_fetch($stmt)){
                    if(!password_verify($old_password, $hashed_old_password)){
                        //if password is correct, start new session
                        $old_password_err = "The old password you entered is not valid.";
                        
                          // header("location: admin.php");
                           
                        
            
                    }else{
                        //$old_password_err = "The old password you entered is not valid.";
                        //header("location: admin.php");
                        //checking if password is empty
    if(empty(trim($_POST["password"]))){
      $password_err = "Please enter your password.";
  }else{
      if(strlen(trim($_POST["password"])) < 6){
          $password_err = "Password must be atleast 6 characters.";
      }else{
          $password = trim($_POST["password"]);
      }
      //validate confirm_password.
      if(empty(trim($_POST["confirm_password"]))){
      $confirm_password_err = "Please confirm your password.";
      }else{
          $confirm_password = trim($_POST["confirm_password"]);
          if(empty($password_err) && ($password != $confirm_password)){
              $confirm_password_err = "Password did not match.";
          }}}
          if(empty($password_err) && empty($confirm_password_err)){
            
             //Select statement
    $sql = "SELECT id, username, pass, categories FROM login WHERE username =? AND categories=?";
    if($stmt = mysqli_prepare($link, $sql)){
        //bind the variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $category);
        
       //set parameters
       $param_username = $username;
       $param_Category = $category;
       
        //executing the statement
        if(mysqli_stmt_execute($stmt)){
            //store result
            mysqli_stmt_store_result($stmt);

            //checking if username exits, if yes verified password
            if(mysqli_stmt_num_rows($stmt) > 0){
                
                //Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $category);
               
                
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        //if password is correct, start new session
                     //if password is the old password.

                     $password_err = "You cannot use the old password.";
                    }else{
                      //update password in database
                      $password =password_hash($password, PASSWORD_DEFAULT);
                      //$sql = "SELECT id FROM userlogin WHERE username = $username";
                      $sql= "UPDATE login SET pass=? WHERE username='$username' AND categories='$category'";
                     //$sql = "INSERT INTO userlogin (pass) VALUES (?) WHERE username = $username";
                      if($stmt = mysqli_prepare($link, $sql)){
                          //bind variables to the prepared statement as parameters.
                          mysqli_stmt_bind_param($stmt, "s", $param_password);
                          
                         //$param_username = $username;
                         $param_password = $password;
                         //$param_category = $category;

                          
                          if(mysqli_stmt_execute($stmt)){
                             echo $registration_succ = "Registration successful.";
                              //redirecting to login page
                              header("location: location.php");
                          }
                      }
                  }
                }else{
                  $username_err = "No account found with that username.";
          }}

                    }
                
            }
        }else{
            echo "Error! Please try again later.";
        }}}}}
        //close statement
        mysqli_stmt_close($stmt);
    }
}
//close connection
//mysqli_close($link);
}




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
  <title>Change password | Uniben</title>
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
      <h4 style="text-transform: capitalize;">Username: <?php echo $username ?></h4>
      <!--<h4 style="text-transform: capitalize;">Category: <?php// echo $category ?></h4>-->

        <div class="">
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; 
            display: block; 
            margin-left: auto;
            margin-right: auto;
            text-align: left;
        }
        
    </style>
        <div class="wrapper">
       
        <h2>Change your password</h2>
        <!--<p>Please fill in your credentials to login.</p>-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($old_password_err)) ? 'has-error' : ''; ?>">
                <label>Enter your old password</label>
                <input type="password" name="old_password" class="form-control" value="<?php echo $old_password; ?>">
                <span class="help-block"><?php echo $old_password_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group">
              <a href="location.php" class="btn btn-danger">Cancel</a>
                <input type="submit" class="btn btn-primary" value="Submit">
                
            </div>
            
        </form>
        </div>
    
        </div>
      </div>
    </div> <!-- .content-wrapper -->
  </main> <!-- .cd-main-content -->
  <script src="asset/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
  <script src="asset/js/menu-aim.js"></script>
  <script src="asset/js/main.js"></script>
</body>
</html>