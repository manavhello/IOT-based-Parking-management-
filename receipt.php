<!DOCTYPE html>
<html>

<head>
    <title>Booking Receipt</title>
</head>

<body>
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

    // Retrieve the booking ID from the query parameter
    $bookingId = $_GET['ID'];

    // Fetch data from the database based on the booking ID
    $sql = "SELECT * FROM user WHERE ID = $bookingId";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['FullName'];
        $phone = $row['PhoneNumber'];
        $vehicleNumber = $row['VehicleNumber'];
        $vehicleType = $row['VehicleType'];
    }
    ?>

    <p><strong>Name:</strong> <span id="name"><?php echo $name; ?></span></p>
    <p><strong>Phone Number:</strong> <span id="phone"><?php echo $phone; ?></span></p>
    <p><strong>Vehicle Number:</strong> <span id="vehicle-number"><?php echo $vehicleNumber; ?></span></p>
    <p><strong>Vehicle Type:</strong> <span id="vehicle-type"><?php echo $vehicleType; ?></span></p>

    <h2>Booking Confirmation:</h2>
    <p>Your parking slot has been successfully booked.</p>

    <h2>QR Code:</h2>
    <!-- You can display a QR code here if needed -->

    <p>Thank you for using our service. Have a great day!</p>
</body>

</html>
