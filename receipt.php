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
                <li><button type="submit" onclick="window.location.href = 'dashboard.php';" class="logout-btn"><b>dashboard</b></button></li>
                <li><button onclick="logout()" class="logout-btn"><b>Log Out</b></button></li>
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
        $dbBooking = 'booking';
        $dbRegistration = 'registration';
        $con = new mysqli($host, $user, $pwd, $dbBooking);

        // Check the connection
        if ($con->connect_error) {
            die('Connection failed : ' . $con->connect_error);
        }

        // Retrieve the booking ID from the query parameter if it exists
        $bookingId = isset($_GET['ID']) ? intval($_GET['ID']) : null;
        $slotNumber = isset($_GET['Slot']) ? intval($_GET['Slot']) : null;

        session_start();
        if (!isset($_SESSION['authenticated'])) {
            // Redirect the user to the login page if not logged in
            header("Location: index.html");
            exit(); // Stop executing the rest of the code
        }
        $username = $_SESSION['username']; // Fetch the username from the session

        if (!isset($bookingId)) {
            echo "<p>Booking ID not specified.</p>";
        } elseif (!isset($slotNumber)) {
            echo "<p>Slot Number not specified.</p>";
        } else {
            // Fetch data from the booking database based on the booking ID
            $sql = "SELECT * FROM user WHERE ID = $bookingId";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['FullName'];
                $phone = $row['PhoneNumber'];
                $vehicleNumber = $row['VehicleNumber'];
                $vehicleType = $row['VehicleType'];
                $slotNumber =  $row["SlotNumber"];

                // Fetch user's email address from the registration database
                $connRegistration = new mysqli($host, $user, $pwd, $dbRegistration);
                $sqlRegistration = "SELECT Email FROM users WHERE name = '$username'";
                $resultRegistration = $connRegistration->query($sqlRegistration);
                if ($resultRegistration->num_rows > 0) {
                    $rowRegistration = $resultRegistration->fetch_assoc();
                    $userEmail = $rowRegistration['Email']; // Retrieve the user's email address
                } else {
                    echo "<p>User email not found.</p>";
                    $userEmail = ''; // Set user's email address to empty
                }

            } else {
                echo "<p>No booking found with the specified ID.</p>";
                // Set default values for variables to avoid undefined variable warnings
                $name = '';
                $phone = '';
                $vehicleNumber = '';
                $vehicleType = '';
                $userEmail = ''; // Set user's email address to empty
            }
        }
        ?>

        <?php if ($bookingId !== null) : ?>
            <div class="bdetails">
                <p><strong>Hello:</strong> <span id="user-name"><?php echo $username; ?></span></p>
                <p><strong>Slot Number:</strong> <span id="slot-number"><?php echo $slotNumber; ?></span></p>
                <!-- <p><strong>Name:</strong> <span id="name"><?php echo $name; ?></span></p> -->
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
            date_default_timezone_set('Asia/Kolkata');
            // JavaScript code to generate and display the QR code
            echo '<script>';

            // Get the current time
            $currentDate = date('Y-m-d');
            $currentTime = date('H:i:s');

            echo 'var name = "' . $name . '";';
            echo 'var phnmbr = "' . $phone . '";';
            echo 'var vhnmbr = "' . $vehicleNumber . '";';
            echo 'var vhntp = "' . $vehicleType . '";';
            echo 'var cdate = "' . $currentDate . '";';
            echo 'var ctime = "' . $currentTime . '";';

            // Construct the URL with the current date and time
            echo 'var dataText = "Name : " + name + " Phone Number : " + phnmbr + " Vehicle Number : " + vhnmbr + " Vehicle Type : " + vhntp + " current time : " + ctime + " current date : " + cdate ;';
            echo 'var apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" + encodeURIComponent(dataText);';

            // Generate the iframe HTML with the QR code URL
            echo 'var ifr = "<iframe src=\"" + apiUrl + "\" height=\"200\" width=\"200\"></iframe>";';

            // Display the QR code
            echo 'document.getElementById("qrcode").innerHTML = ifr;';
            echo '</script>';
            $_SESSION['slotNumber'] = $slotNumber; // Optionally, store the username in the session
            ?>


            <p>Thank you for using our service. Have a great day!</p>
        <?php endif; ?>
    </div>

    <?php
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
    require 'phpmailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'ourparkit@gmail.com';
    $mail->Password = 'zaae hlaw jcbh pgmi';
    $mail->SMTPSecure = 'tls';

    $mail->setFrom('ourparkit@gmail.com', 'ParkIT');
    $mail->addAddress($userEmail, $name); // Send email to the user who booked the slot
    $mail->isHTML(true);
    $mail->Subject = 'Parking Slot Booking Confirmation';
    $mail->Body = '
    <p>Dear ' . $username . ',</p>
    <p>Your parking slot has been successfully booked with ParkIT.</p>
    <h2>Booking Details:</h2>
    <ul>
        <li>Vehicle Number: ' . $vehicleNumber . '</li>
        <li>Slot Number: ' . $slotNumber . '</li>
        <li>Date: ' . date('Y-m-d') . '</li>
        <li>Time: ' . date('H:i:s') . '</li>
    </ul>
    <p>Thank you for choosing ParkIT. Have a pleasant experience!</p>
    <p>Best regards,<br>ParkIT Team</p>';

    sleep(4);

    // Send email
    if ($mail->send()) {
        echo 'Email sent successfully';
    } else {
        echo 'Error: ' . $mail->ErrorInfo;
    }
    ?>

</body>

</html>
