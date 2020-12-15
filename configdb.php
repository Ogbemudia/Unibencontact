<?php
//connect to our database.
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Pa55w0rd@1');
define('DB_NAME', 'admin_uniben_contact');
$link = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//$link = @mysqli_connect("localhost:3306", "root", "Pa55w0rd@1", "admin_uniben_contact");

//checking connection
if(mysqli_connect_errno() > 0){
die("Error: unable to connect: ". mysqli_connect_errno());
}else{
   // echo "<p>Connection to database is successful</p>";
}
?>