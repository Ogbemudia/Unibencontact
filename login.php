
<?php
    include 'loginback.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | UniBEN</title>
    
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
            

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="https://uniben.edu" target="blank" >Uniben</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
       <!--  <a class="nav-link" href="index.php" target="blank" style="color: #fff;">Contact us <span class="sr-only">(current)</span></a>
      </li>
      
     <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>-->
    </ul>
    
    <ul class="navbar-nav  my-2 my-lg-0">
    <li class="nav-item">
        <a class="nav-link" href="index.php" style="color: #fff;">Contact us</a>
      </li>
      </ul>

        </header>
        <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; 
            display: block; 
            margin-left: auto;
            margin-right: auto;
        }
        
    </style>
        <div class="wrapper">
        <h2>User Login</h2>
        <!--<p>Please fill in your credentials to login.</p>-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            
        </form>
        </div>

        <footer>
        <div class="sub-footer">
            <div class="sub-footer-left">Copyright &copy; 2020, University of Benin</div>
            <div class="sub-footer-right">Designed by University of Benin, Web Unit, ICTU</div>
        </div>
            
        </footer>
        
    </div>
    
</body>
</html>