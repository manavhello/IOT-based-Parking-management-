<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $servername = "localhost"; // Change this to your database server name
    $username_db = "root"; // Change this to your database username
    $password_db = ""; // Change this to your database password
    $dbname = "adminlogin"; // Change this to your database name

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to retrieve password for the provided username
    $stmt = $conn->prepare("SELECT password FROM admintable WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Verify the password
        if ($password === $stored_password) {
            session_start();
             // Start the session
            $_SESSION['admin_authenticated'] = true;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Password is incorrect, display error message
            echo "Invalid username or password.";
        }
    } else {
        // Username doesn't exist, display error message
        echo "Invalid username or password.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>