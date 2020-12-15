<?php
require_once('session.php');
//login();
    
require_once('configdb.php');



//initializng variables
$username = "";
$password = "";
$category = "";
$username_err = "";
$password_err = "";

//processing data from login form
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    //Checking if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    }else{
        $username = trim($_POST["username"]);
    }

    //checking if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    }else{
        $password = trim($_POST["password"]);
    }

    //Validating inputs
    if(empty($username_err) && empty($password_err)){
        
        //Select statement
        $sql = "SELECT id, username, pass, categories FROM login WHERE username = ? ";
        if($stmt = mysqli_prepare($link, $sql)){
            //bind the variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
           //set parameters
           $param_username = $username;
           
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
                           // echo $category;
                           $login_date=date('y/m/d h:i:s');
                           $sql4= "UPDATE login SET history= 'Last seen on: $login_date' WHERE username='$username' AND categories='$category'";
                          // $sql4 = "UPDATE login SET history = 'Last seen on: $login_date' WHERE username=$username";
                           if(mysqli_query($link, $sql4)) {
                            $_SESSION['userlogin'] = $username;
                            $_SESSION['categories'] = $category;
                            $_SESSION["id"] = $id;
                            $_SESSION['loggedin'] = time(); // Taking now logged in time.
                            // Ending a session in 2 hours from the starting time.
                            $_SESSION['expire'] = $_SESSION['loggedin'] + (120 * 2);
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
                            
                           }else{
                               echo "unable to update";
                           }
                            
                
                        }else{
                            $password_err = "The password you entered is not valid.";

                        }
                    }
                }else{
                    $username_err = "No account found with that username.";
                }
            }else{
                echo "Error! Please try again later.";
            }
            //close statement
            mysqli_stmt_close($stmt);
        }
    }
    //close connection
    mysqli_close($link);
}
?>