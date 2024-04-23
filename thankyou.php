<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Connect to the database
    $servername = "localhost"; // Change this to your database server name
    $username_db = "root"; // Change this to your database username
    $password_db = ""; // Change this to your database password
    $dbname = "registration"; // Change this to your database name

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to retrieve password for the provided username
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $stored_password);
        $stmt->fetch();

        // Verify the password
        if ($password === $stored_password) {
            // Password is correct, set session variable and redirect to dashboard
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username; // Optionally, store the username in the session
            $_SESSION['name'] = $name; // Store the name in the session
            header("Location: home.html");
            exit();
        } else {
            // Password is incorrect, display error message
            // echo "Invalid username or password."; // Remove this line
        }
    } else {
        // Username doesn't exist, display error message
        // echo "Invalid username or password."; // Remove this line
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
               <li><button onclick="logout()" class="logout-btn"><b>Log Out</b></button></li> 

                <?php
                // Check if the user is authenticated
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

        // Check if slot number is available in session
        if (!isset($_SESSION['slotNumber'])) {
            echo "<p>Slot Number not specified.</p>";
        } else {
            $slotNumber = $_SESSION['slotNumber'];
            // Fetch data from the database based on the slot number
            $sql = "DELETE FROM user WHERE SlotNumber = '$slotNumber'";

            if ($con->query($sql) === TRUE) {
                // Fetch the name from the session
                $username = $_SESSION['username'];
                echo "<p><h1>Thank you, $username :)<h1></p>";
                echo "<p><h2>Payment Successful</h2></p>";
                echo "<p><h3>Thank you for choosing Park IT,<br> have a great day!</br></h3></p>";
            } else {
                echo "<p>Error deleting records: " . $con->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
