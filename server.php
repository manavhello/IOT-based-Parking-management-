<?php
// Initialize session
session_start();

// Initialize errors array
if (!isset($errors)) $errors = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize form data
    $loginId = htmlspecialchars($_POST["loginId"]);
    $db_password = $_POST["loginPassword"];
    
    // Connect to MySQL database (replace with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = ""; // Use the database password, not an empty string
    $dbname = "registration";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate username and password
    $username = mysqli_real_escape_string($conn, $_POST['loginId']); // Corrected the variable name here
    $password = mysqli_real_escape_string($conn, $_POST['loginPassword']); // Corrected the variable name here
    
    // Hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the credentials are correct
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($_POST['loginPassword'], $row['password'])) { // Corrected the variable name here
            // Password is correct, start a new session
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    } else {
        array_push($errors, "Wrong username/password combination");
    }
    
    $conn->close();
}
?>
