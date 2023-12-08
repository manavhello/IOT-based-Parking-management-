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
                <li><a href="index.html">Home</a></li>
                <li><a href="about us.html">About Us</a></li>
                <li><a href="contact us.html">Contact Us</a></li>
                <!-- <li><a href="receipt.php">Receipt</a></li> -->
                
                <?php
                // Check if the last booking details are available in the session
                session_start();
                if (isset($_SESSION['last_booking_name']) && isset($_SESSION['last_booking_slot'])) {
                    $lastBookingName = $_SESSION['last_booking_name'];
                    $lastBookingSlot = $_SESSION['last_booking_slot'];

                    // Display the last booking details in the navigation bar
                    echo '<li>Last Booking: Slot ' . $lastBookingSlot . ' by ' . $lastBookingName . '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="body receipt">
    <h1>Booking Receipt</h1>

    <h2>Booking Details:</h2>
    <?php
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

    // Retrieve the booking ID from the query parameter if it exists
    $bookingId = isset($_GET['ID']) ? intval($_GET['ID']) : null;
    $slotNumber = isset($_GET['Slot']) ? intval($_GET['Slot']) : null;
    // // Debugging code
    // echo "<p><strong>Booking ID:</strong> $bookingId</p>"; // Check the value of bookingId
    if (!isset($bookingId)) {
        echo "<p>Booking ID not specified.</p>";
    } elseif (!isset($slotNumber)) {
        echo "<p>Slot Number not specified.</p>";
    } else {
        // Fetch data from the database based on the booking ID
        $sql = "SELECT * FROM user WHERE ID = $bookingId";

        // // Debugging code
        // echo "<p>SQL Query: $sql</p>"; // Check the SQL query being executed

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['FullName'];
            $phone = $row['PhoneNumber'];
            $vehicleNumber = $row['VehicleNumber'];
            $vehicleType = $row['VehicleType'];
        } else {
            echo "<p>No booking found with the specified ID.</p>";
            // Set default values for variables to avoid undefined variable warnings
            $name = '';
            $phone = '';
            $vehicleNumber = '';
            $vehicleType = '';
        }
    }
    ?>

    <?php if ($bookingId !== null) : ?>
        <div class="bdetails">
        <p><strong>Slot Number:</strong> <span id="slot-number"><?php echo $slotNumber; ?></span></p>
        <p><strong>Name:</strong> <span id="name"><?php echo $name; ?></span></p>
        <p><strong>Phone Number:</strong> <span id="phone"><?php echo $phone; ?></span></p>
        <p><strong>Vehicle Number:</strong> <span id="vehicle-number"><?php echo $vehicleNumber; ?></span></p>
        <p><strong>Vehicle Type:</strong> <span id="vehicle-type"><?php echo $vehicleType; ?></span></p>
        </div>
        <h2>Booking Confirmation:</h2>
        <p>Your parking slot (Slot No.: <?php echo $slotNumber; ?>) has been successfully booked.</p>
        
        <h2>QR Code:</h2>
        <!-- You can display a QR code here if needed -->
        <div id="qrcode"></div>

        <?php
        // JavaScript code to generate and display the QR code
        echo '<script>';
        echo 'var name = "' . $name . '";';
        echo 'var phnmbr = "' . $phone . '";';
        echo 'var vhnmbr = "' . $vehicleNumber . '";';
        echo 'var vhntp = "' . $vehicleType . '";';
        echo 'var url = "https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=Name : " + name + " Phone Number : " + phnmbr + " Vehicle Number : " + vhnmbr + " Vehicle Type : " + vhntp;';
        echo 'var ifr = `<iframe src="${url}" height="200" width="200"></iframe>`;';
        echo 'document.getElementById("qrcode").innerHTML = ifr;';
        echo '</script>';
        ?>

        <p>Thank you for using our service. Have a great day!</p>
    <?php endif; ?>
    </div>
</body>

</html>
