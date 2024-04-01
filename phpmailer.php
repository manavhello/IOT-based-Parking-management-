<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

date_default_timezone_set("Asia/Calcutta");

$allotmentTime = '2024-04-22 12:22:31';
$currentTimestamp = time(); // Current Unix timestamp

// Convert allotment time to Unix timestamp
$allotmentTimestamp = strtotime($allotmentTime);

// Calculate the difference in seconds
$timeDifference = $allotmentTimestamp-$currentTimestamp;

// Convert seconds to minutes
$timeDifferenceInMinutes = round($timeDifference / 60);

echo "Difference in minutes: $timeDifferenceInMinutes minutes";

if($timeDifferenceInMinutes <= 10){
  include_once("mailsend/class.phpmailer.php");

  $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ourparkit@gmail.com'; // Your Gmail username
            $mail->Password = 'MiniProject@admn'; // Your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('ourparkit@gmail.com', 'ParkIT'); // Sender's email address
            $mail->addAddress('dheerajrapelli@gmail.com'); // Recipient's email address

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Your Parking Booking is Expiring Soon";
            $mail->Body = "Dear user, your parking booking (ID: $booking_id) is about to expire. Please vacate the parking spot.";

  

  if(!$mail->Send()) {
  echo "<br>mail not sent";
  }else{
  echo "<br>mail sent";
  }
  die;
}

echo "Grater 10 value";

die;