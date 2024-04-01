<?php
// Connect to the database
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "booking"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID parameter is set
if(isset($_POST['id'])) {
    // Get the ID value from the form submission
    $id = $_POST['id'];

    // Prepare SQL statement to delete the row
    $sql = "DELETE FROM user WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Redirect back to the admin dashboard
header("Location: admin_dashboard.php");
exit(); // Ensure that no further code is executed after redirection
?>