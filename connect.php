<?php
      session_start(); // Start the session
      if (!isset($_SESSION['authenticated'])) {
          // Redirect the user to the login page if not logged in
          header("Location: index.html");
          exit(); // Stop executing the rest of the code
      }
      $username_s = $_SESSION['username']; // Fetch the username from the session
error_reporting(E_ALL);
ini_set('display_errors', '1');
$n = 17;

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

if (isset($_POST['submit'])) {
    date_default_timezone_set('Asia/Kolkata');
    $con = connectToDatabase();

    $username = $_POST["name"];
    $mobile = $_POST['mobile'];
    $vehicle = $_POST['num'];
    $type = $_POST['vehicle-type'];
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    $time_duration =  $_POST['hour']; // in hours

    // Check if a booking with the same vehicle number already exists
    $checkBookingQuery = "SELECT * FROM user WHERE VehicleNumber = '$vehicle'";
    $existingBooking = $con->query($checkBookingQuery);

    if ($existingBooking->num_rows > 0) {
        // An existing booking with the same vehicle number was found
        echo "<script>alert('You have already booked a slot with this vehicle number.');</script>";
    } else {
        // Calculate the lowest available slot
        $lowestAvailableSlot = 1;
        while (true) {
            $checkSlotQuery = "SELECT * FROM user WHERE SlotNumber = $lowestAvailableSlot";
            $result = $con->query($checkSlotQuery);
            if ($result->num_rows == 0) {
                break;
            }
            $lowestAvailableSlot++;
        }

        if ($lowestAvailableSlot <= $n) {
            // Insert the booking with the lowest available slot number
            $sql0 = "INSERT INTO user (FullName, PhoneNumber, VehicleNumber, VehicleType, SlotNumber, date_details, time_details, time_duration, email) 
                      VALUES ('$username', '$mobile', '$vehicle', '$type', $lowestAvailableSlot, '$currentDate', '$currentTime', '$time_duration','$username_s')";
    
            if ($con->query($sql0) === TRUE) {
                // Data was inserted successfully

                // Retrieve the auto-generated booking ID
                $bookingId = $con->insert_id;

                // Close the database connection
                $con->close();

                // Redirect to receipt.php with the booking ID and slot number as query parameters
                header("Location: receipt.php?ID=" . $bookingId . "&Slot=" . $lowestAvailableSlot);
                exit;
            } else {
                // Booking was not successful
                echo "Error: " . $sql0 . "<br>" . $con->error;
            }
        } else {
            // Parking is full
            echo "<script>alert('Parking is full. Please try again later.');</script>";
        }
    }
} else if (isset($_GET['update']) && $_GET['update'] === 'true') {
    // handle the request to update the booked slots count
    $con = connectToDatabase();

    // Query to count the number of booked slots
    $countBookedSlotsQuery = "SELECT COUNT(*) AS bookedSlots FROM user";
    $countBookedSlotsResult = $con->query($countBookedSlotsQuery);

    if ($countBookedSlotsResult) {
        $row = $countBookedSlotsResult->fetch_assoc();
        $bookedSlots = $n-$row['bookedSlots'];

        // Close the database connection
        $con->close();

       // Return the booked slots count and the total slots count as JSON response
       echo json_encode(array('bookedSlots' => $bookedSlots, 'totalSlots' => $n));  
    } else {
        // Handle any errors with the query
        echo "Error: " . $countBookedSlotsQuery . "<br>" . $con->error;
    }
}
?>