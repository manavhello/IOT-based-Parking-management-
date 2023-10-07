<?php
if (isset($_POST['submit'])){
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'booking';
    echo 'one';
   $con = new mysqli($host, $user, $pwd, $db);

    if ($con->connect_error){
      die('Connection failed : ' . $con->connect_error);
   }
    
    $username = $_POST["name"];
    
    $mobile = $_POST['mobile'];
    
    $vehicle = $_POST['num'];
   
    $type = $_POST['vehicle-type'];
    
    
    
   $sql0 = "INSERT INTO user (FullName, PhoneNumber, VehicleNumber, VehicleType) VALUES ('$username', '$mobile', '$vehicle', '$type')";
    
    if ($con->query($sql0) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql0 . "<br>" . $con->error;
   }

    $con->close(); 
}
?>

