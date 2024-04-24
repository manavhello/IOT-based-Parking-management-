<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

// Function to connect to the database
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

// Connect to the database
$con = connectToDatabase();

// Get the current time
$currentDateTime = date('Y-m-d H:i:s');

// Calculate the warning time (e.g., 10 minutes before expiration) for each booking
$warningTime = date('Y-m-d H:i:s', strtotime('-59 minutes', strtotime($currentDateTime)));


// Query for bookings that are nearing expiration
$sql = "SELECT * FROM user WHERE DATE_ADD(CONCAT(date_details, ' ', time_details), INTERVAL time_duration HOUR) <= '$warningTime'";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    require_once 'email_config.php'; // Include email configuration

    // Loop through each booking nearing expiration
    while ($row = $result->fetch_assoc()) {
        $userEmail = $row['email']; // User's email address
        $name = $row['FullName']; // User's name
        $slotNumber = $row['SlotNumber']; // Slot number

        // Create a PHPMailer instance
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'ourparkit@gmail.com'; // Your Gmail email address
        $mail->Password = 'zaae hlaw jcbh pgmi'; // Your Gmail password
        $mail->SMTPSecure = 'tls';

        // Set email content
        $mail->setFrom('ourparkit@gmail.com', 'ParkIT'); // Sender's email and name
        $mail->addAddress($userEmail, $name); // Recipient's email and name
        $mail->isHTML(true);
        $mail->Subject = 'Parking Time Expiry Notification'; // Email subject
        $mail->Body = 'Dear ' . $name . ',<br><br>Your parking time for slot number ' . $slotNumber . ' is about to expire. Please move your vehicle to avoid penalties.<br><br>Best regards,<br>ParkIT Team'; // Email body

        // Send email
        if ($mail->send()) {
            echo 'Notification email sent successfully to ' . $userEmail . '<br>';
        } else {
            echo 'Error sending notification email to ' . $userEmail . ': ' . $mail->ErrorInfo . '<br>';
        }
    }
} else {
    echo 'No bookings nearing expiration.<br>';
}

// Close the database connection
$con->close();
?>
