<?php
session_start();

// Establish a database connection
$host = 'localhost';
$user = 'root';
$pwd = '';
$db = 'booking';
$con = new mysqli($host, $user, $pwd, $db);

// Check the connection
if ($con->connect_error) {
    die('Connection failed : ' . $con->connect_error);
}

// Check if slot number is available in session
if (!isset($_SESSION['slotNumber'])) {
    echo "<p>Slot Number not specified.</p>";
    exit; // Exit execution if slot number is not specified
} else {
    $slotNumber = $_SESSION['slotNumber'];
    // Fetch data from the database based on the slot number
    $sql = "SELECT * FROM user WHERE SlotNumber = '$slotNumber'";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['FullName'];
        $phone = $row['PhoneNumber'];
        $vehicleNumber = $row['VehicleNumber'];
        $vehicleType = $row['VehicleType'];
        $date_details = $row['date_details'];
        $time_details = $row['time_details'];
        $time_duration = $row['time_duration'];

        // Get the current date and time in Asia/Kolkata timezone
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = new DateTime('now');

        // Convert the fetched date and time details to DateTime object
        $bookingDateTime = new DateTime($date_details . ' ' . $time_details);

        // Calculate the time difference
        $timeDifference = $currentDateTime->diff($bookingDateTime);

        // Calculate the total time difference in minutes
        $totalMinutes = $timeDifference->days * 24 * 60;
        $totalMinutes += $timeDifference->h * 60;
        $totalMinutes += $timeDifference->i;

        // Calculate the bill based on time difference
        $bill = $totalMinutes * 0.5; // 1 minute = 0.5 paise, divide by 2 to convert to rupees
        if($bill<=30){
            $bill=30;
        }

        // Save $bill into a session variable
        $_SESSION['bill'] = $bill;

    } else {
        echo "<p>No booking found with the specified Slot Number.</p>";
        // Set default values for variables to avoid undefined variable warnings
        $name = '';
        $phone = '';
        $vehicleNumber = '';
        $vehicleType = '';
        $date_details = '';
        $time_details = '';
        $time_duration = '';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Receipt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="index.html">ParkIT</a></div>
            <ul>
            <li><a href="home.html">Home</a></li>
                <li><a href="about us.html">About Us</a></li>
                <li><a href="rules_regulations.html">Rules and Regulations</a></li>
                <li><a href="contact us.html">Contact Us</a></li>  
                <li><button type="submit" onclick="dashboard()" class="logout-btn"><b>dashboard</b></button></li>

                <?php
                // Check if the last booking details are available in the session
                if (isset($_SESSION['authenticated'])) {
                    echo '<li><a href="home.html"></a></li>';
                } else {
                    echo "<li><a href='login.html'>Login</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="body receipt">

        <h1>Bill Receipt</h1>

        <h3>Bill Details:</h3>

        <?php if (isset($_SESSION['slotNumber'])) : ?>
            <div class="bdetails">
                <p><strong>Slot Number:</strong> <span id="slot-number"><?php echo $slotNumber; ?></span></p>
                <p><strong>Name:</strong> <span id="name"><?php echo $name; ?></span></p>
                <p><strong>Phone Number:</strong> <span id="phone"><?php echo $phone; ?></span></p>
                <p><strong>Vehicle Number:</strong> <span id="vehicle-number"><?php echo $vehicleNumber; ?></span></p>
                <p><strong>Vehicle Type:</strong> <span id="vehicle-type"><?php echo $vehicleType; ?></span></p>
                <p><strong>Date:</strong> <span id="date_details"><?php echo $date_details; ?></span></p>
                <p><strong>Time details:</strong> <span id="time_details"><?php echo $time_details; ?></span></p>
                <p><strong>Time duration:</strong> <span id="time_duration"><?php echo $time_duration; ?></span></p>
                <?php if (isset($timeDifference)) : ?>
                    <p><strong>Time Difference:</strong> <?php echo $timeDifference->format('%d days %h hours %i minutes'); ?></p>
                    <p><strong>Total Bill:</strong> ₹<?php echo number_format($bill, 2); ?></p>
                <?php endif; ?>
            </div>
        
            <?php
            // JavaScript code to generate and display the QR code
            echo '<script>';

            // Construct the URL with the current date and time
            echo 'var name = "' . $name . '";';
            echo 'var phnmbr = "' . $phone . '";';
            echo 'var vhnmbr = "' . $vehicleNumber . '";';
            echo 'var vhntp = "' . $vehicleType . '";';
            echo 'var cdate = "' . $currentDate . '";';
            echo 'var ctime = "' . $currentTime . '";';
            echo 'var cdatedetails = "' . $date_details . '";';
            echo 'var ctimedetails = "' . $time_details . '";';
            echo 'var ctimeduration = "' . $time_duration . '";';

            echo 'var url = "https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=Name : " + name + " Phone Number : " + phnmbr + " Vehicle Number : " + vhnmbr + " Vehicle Type : " + vhntp + " current time : " + ctime + " current date : " + cdate ;';

            echo '</script>';
            ?>
        <?php endif; ?>

        <!-- Pay Now Button -->
        <div class="pay-now-button">
            <form action="card.php">
                <button type="submit" class="logout-btn">Pay Now</button>
            </form>
        </div>
    </div>
</body>
</html>
