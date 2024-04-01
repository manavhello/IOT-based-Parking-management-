<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $name = htmlspecialchars($_POST["name"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $email = htmlspecialchars($_POST["email"]);
    $db_password = htmlspecialchars($_POST["password"]);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit; // Stop further execution
    }

    // Validate password length
    if (strlen($db_password) < 6) {
        echo "Password should be at least 6 characters long";
        exit; // Stop further execution
    }

    // Connect to MySQL database (replace with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registration";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, mobile, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $mobile, $email, $db_password);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
        header("Location: login.html"); // Redirect to home.html
        exit; // Stop further execution
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
