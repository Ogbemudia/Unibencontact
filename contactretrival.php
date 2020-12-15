
    
    <?php
    //errors
    $missingName = '<p><strong>Please enter your name!</strong></p>';
    $missingEmail = '<p><strong>Please enter your email address!</strong></p>';
    $invalidEmail = '<p><strong>Please enter your a valid email address!</strong></p>';
    $missingSubject = '<p><strong>Please enter the subject of your message!</strong></p>';
    $missingMessages = '<p><strong>Please enter your message!</strong></p>';
    $missingCategory = '<p><strong>Please select your message category!</strong></p>';
    $successMessage ='<p><strong>Thank you for contacting us, we will get back to u soon.!</strong></p>';
    
    //Include required phpmailer files
    require 'asset/phpmailer/includes/PHPMailer.php';
    require 'asset/phpmailer/includes/SMTP.php';
    require 'asset/phpmailer/includes/Exception.php';
    //Define name spaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Create instance of phpmailer
    $mail = new PHPMailer();
    //Set mailer to use smtp
    $mail -> isSMTP();
    //Define smtp host
    $mail -> Host = "smtp.gmail.com";
    //Enable smtp authentication
    $mail -> SMTPAuth = "true";
    //Set type of encription (ssl/tls)
    $mail -> SMTPSecure = "tls";
    //Set port to connect smtp
    $mail -> Port = "587";
    //Set gmail username
    $mail -> Username = "info@uniben.edu";
    //Set gmail password
    $mail -> Password = "Pa55w0rd@1";
    $mail -> isHTML(true);
    //Add reciving email
   $mail -> addAddress("registrar@uniben.edu");


   $name = '';
   $email = '';
   $subject = '';
   $messages = '';
   $category = '';
   $_id = '';
    //if the user has submitted the form
    if(isset($_POST["submit_msg"])){

        //user input
        
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $messages = $_POST["messages"];
        $category = $_POST["category"];
        $errors = '';

        //check for errors
        if(!$name){
            $errors .= $missingName;
        }else{
           $name = filter_var($name, FILTER_SANITIZE_STRING);
        }
        
        if(!$email){
                $errors .= $missingEmail;
            }else{
              $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors.= $invalidEmail;
                }
            }

            if(!$subject){
                $errors .= $missingSubject;
            }else{
                $subject = filter_var($subject, FILTER_SANITIZE_STRING);
            }

            if($category == "1"){
                $errors .= $missingCategory;
            }else{
                $category = filter_var($category, FILTER_SANITIZE_STRING);
            }
                
        if(!$messages){
            $errors .= $missingMessages;
        }else{
            $messages = filter_var($messages, FILTER_SANITIZE_STRING);
        }
        
            //if there are any errors
        if($errors){
            //print error message
            $resultMessages = "<div class='alert alert-danger'>$errors</div>";
        }else{
        //no errors
        //connect to our database.
        require_once('configdb.php');


        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $messages = $_POST["messages"];
        $category = $_POST["category"];
        $action = "Unread";

        $name = mysqli_real_escape_string($link, $name);
        $email = mysqli_real_escape_string($link, $email);
        $subject = mysqli_real_escape_string($link, $subject);
        $messages = mysqli_real_escape_string($link, $messages);
        $category = mysqli_real_escape_string($link, $category);
        $action = mysqli_real_escape_string($link, $action);

        $sql = "INSERT INTO contact_us (name, email, subject, message, action, categories) VALUES ('$name', '$email', '$subject', '$messages', '$action', '$category')";
        //Add record to database
      
            if(mysqli_query($link, $sql)) {
                $resultMessages = $successMessage;
				 $name = '';
                   $email = '';
                   $subject = '';
                   $messages = '';
                   $action = '';
                   $category = '';
				   $_id = '';
                }else{
                    $resultMessages = "<p>Unable to send message</p>";
                }
        
        //send email
        //Set email subject
        $mail -> Subject = $subject;
        //Set sender email
        $mail -> setFrom($email, "Contact us");
        //Set email body
        
        $mail -> Body = "";
        $mail -> Body .="<p>From: .$name. </p><br />";
        $mail -> Body .="<p>Email: .$email.</p><br />";
        $mail -> Body .="<p>Subject: .$subject.</p><br />";
        $mail -> Body .="<p>Message: <br /> .$messages.</p>";
    
   
        
                
        //if sent successful
        if($mail -> Send()){
        
            //print success message
            $resultMessages = "<div class='alert alert-success'>$successMessage</div>";
            
        }else{
            //if sent fails
            //print warning message
          //$resultMessages = "<div class='alert alert-warning'>Error! Unable to send message at the moment. Please try again Later!</div>";
            }
        }
                    //Close smtp connection
                    $mail -> smtpClose();
                       
                                                 
         //print result message
         echo $resultMessages;
    }

        
   
    ?>

    
    