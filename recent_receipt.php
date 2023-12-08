<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Function to connect to the database
function connectToDatabase()
{
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'booking';
    $con = new mysqli($host, $user, $pwd, $db);

    if ($con->connect_error) {
        die('Connection failed: ' . $con->connect_error);
    }

    return $con;
}

// Fetch the most recent receipt (you can change the table name if it's different)
$con = connectToDatabase();
$recentReceiptQuery = "SELECT * FROM user ORDER BY BookingID DESC LIMIT 1";
$result = $con->query($recentReceiptQuery);

if ($result && $row = $result->fetch_assoc()) {
    // Display receipt details here
    $bookingID = $row['BookingID'];
    $fullName = $row['FullName'];
    $phoneNumber = $row['PhoneNumber'];
    $vehicleNumber = $row['VehicleNumber'];
    $vehicleType = $row['VehicleType'];
    $slotNumber = $row['SlotNumber'];

    // HTML to display receipt
    echo "<h1>Recent Receipt</h1>";
    echo "<p>Booking ID: $bookingID</p>";
    echo "<p>Full Name: $fullName</p>";
    echo "<p>Phone Number: $phoneNumber</p>";
    echo "<p>Vehicle Number: $vehicleNumber</p>";
    echo "<p>Vehicle Type: $vehicleType</p>";
    echo "<p>Slot Number: $slotNumber</p>";
} else {
    echo "No recent receipt found.";
}

$con->close();
?>
