<?php
session_start();

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

function connectToDatabase()
{
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'booking';
    $con = new mysqli($host, $user, $pwd, $db);

    if ($con->connect_error) {
        die('Connection failed : ' . $con->connect_error);
    }

    return $con;
}


function sendEmailNotification($recipientEmail, $vehicleNumber, $slotNumber, $currentDate, $currentTime)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ourparkit@gmail.com'; 
        $mail->Password = 'zaae hlaw jcbh pgmi'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('ourparkit@gmail.com', 'ParkIT'); 
        $mail->addAddress('dheerajrapelli@gmail.com');
        $mail->isHTML(true);
        $mail->Subject= 'Parking Time Expiry Notification';       
        $mail->Body= 'Your parking time is about to expire. Please move your vehicle to avoid penalties.'; 
        
        $mail->send();
        echo 'Parking Time Expiry email sent successfully.';
    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}


if (isset($_SESSION['authenticated']) && isset($_SESSION['last_booking_name']) && isset($_SESSION['last_booking_slot'])) {
    $username = $_SESSION['last_booking_name'];
    $slotNumber = $_SESSION['last_booking_slot'];

    $con = connectToDatabase();
    $sql = "SELECT * FROM user WHERE FullName = '$username' AND SlotNumber = '$slotNumber'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vehicleNumber = $row['VehicleNumber'];
        $currentDate = $row['date_details'];
        $currentTime = $row['time_details'];
        $recipientEmail = $row['email']; 

        sleep(5);

        sendEmailNotification($recipientEmail, $vehicleNumber, $slotNumber, $currentDate, $currentTime);
    } else {
        echo 'No booking found with the specified details.';
    }

    $con->close();
} else {
    header("Location: index.html");
    exit();
}
?>
