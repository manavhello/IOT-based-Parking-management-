<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST['submit'])) {
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'booking';
    $con = new mysqli($host, $user, $pwd, $db);

    if ($con->connect_error) {
        die('Connection failed : ' . $con->connect_error);
    }

    $username = $_POST["name"];
    $mobile = $_POST['mobile'];
    $vehicle = $_POST['num'];
    $type = $_POST['vehicle-type'];

    // Check if a booking with the same vehicle number already exists
    $checkBookingQuery = "SELECT * FROM user WHERE VehicleNumber = '$vehicle'";
    $existingBooking = $con->query($checkBookingQuery);

    if ($existingBooking->num_rows > 0) {
        // An existing booking with the same vehicle number was found
        echo "<script>alert('You have already booked a slot with this vehicle number.');</script>";
    } else {
        // No existing booking found with the same vehicle number, proceed with the new booking
        $sql0 = "INSERT INTO user (FullName, PhoneNumber, VehicleNumber, VehicleType) VALUES ('$username', '$mobile', '$vehicle', '$type')";

        if ($con->query($sql0) === TRUE) {
            // Data was inserted successfully

            // Retrieve the auto-generated booking ID
            $bookingId = $con->insert_id;

            // Close the database connection
            $con->close();

            // Redirect to receipt.php with the booking ID as a query parameter
            header("Location: receipt.php?ID=" . $bookingId);
            exit;
        } else {
            // Booking was not successful
            echo "Error: " . $sql0 . "<br>" . $con->error;
        }
    }
}
?>
