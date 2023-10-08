
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
        echo "Error: " . $sql0 . "<br>" . $con->error;
    }
}
?>
