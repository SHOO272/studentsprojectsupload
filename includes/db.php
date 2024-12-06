  <?php

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "cms_das";

foreach($db as $key => $value){
define(strtoupper($key), $value);
}

$conn  = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);

$query = "SET NAMES utf8";
mysqli_query($conn ,$query);
// we comment the connection message to hide it from the page 
    // if($connection) {

    // echo "We are connected";

    // } 



// you can use any other method to connect to database, choose what you like !! 
//   $connection = mysqli_connect('localhost', 'root', '', 'cms');  
//     if(!$connection) {
//         die("Database connection failed");
//     }
//     else{
//         echo "we are connected";
//     }
    
    ?>