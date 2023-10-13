<!DOCTYPE html>
<html>

<head>
    <title>Booking Receipt</title>

    <style>
       body {
           display: flex;
           flex-direction: column;
           align-items: center;
           justify-content: center;
           height: 100vh;
           margin: 0;
           font-family: Arial, sans-serif;
       }

       .content {
           text-align: center;
           padding: 20px;
           border: 1px solid #ccc;
           border-radius: 10px;
           background-color: #f9f9f9;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
       }
   </style>

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

    // Retrieve the booking ID from the query parameter if it exists
    $bookingId = isset($_GET['ID']) ? intval($_GET['ID']) : null;

    // // Debugging code
    // echo "<p>Booking ID: $bookingId</p>"; // Check the value of bookingId
    if (!isset($bookingId)) {
        echo "<p>Booking ID not specified.</p>";
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
        <p><strong>Name:</strong> <span id="name"><?php echo $name; ?></span></p>
        <p><strong>Phone Number:</strong> <span id="phone"><?php echo $phone; ?></span></p>
        <p><strong>Vehicle Number:</strong> <span id="vehicle-number"><?php echo $vehicleNumber; ?></span></p>
        <p><strong>Vehicle Type:</strong> <span id="vehicle-type"><?php echo $vehicleType; ?></span></p>

        <h2>Booking Confirmation:</h2>
        <p>Your parking slot has been successfully booked.</p>

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
</body>

</html>