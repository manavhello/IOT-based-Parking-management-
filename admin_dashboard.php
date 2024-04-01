<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset CSS */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* General Styles */
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
        }

        h1 {
            color: #333333;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Buttons */
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #333333;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #555555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
      <center> Welcome to the Admin Dashboard!</center>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>FullName</th>
                    <th>PhoneNumber</th>
                    <th>VehicleNumber</th>
                    <th>VehicleType</th>
                    <th>SlotNumber</th>
                    <th>date_details</th>
                    <th>time_details</th>
                    <th>time_duration</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            session_start(); // Start the session
            // Check if admin is authenticated
            if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
                // If not authenticated, redirect to login page
                header("Location: index.html");
                exit();
            }
// Connect to the database
$servername = "localhost"; // Change this to your database server name
$username_db = "root"; // Change this to your database username
$password_db = ""; // Change this to your database password
$dbname = "booking"; // Change this to your database name

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to retrieve data from the table
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ID"] . "</td>";
        echo "<td>" . $row["FullName"] . "</td>";
        echo "<td>" . $row["PhoneNumber"] . "</td>";
        echo "<td>" . $row["VehicleNumber"] . "</td>";
        echo "<td>" . $row["VehicleType"] . "</td>";
        echo "<td>" . $row["SlotNumber"] . "</td>";
        echo "<td>" . $row["date_details"] . "</td>";
        echo "<td>" . $row["time_details"] . "</td>";
        echo "<td>" . $row["time_duration"] . "</td>";
        echo "<td><form method='post' action='delete_row.php'><button class='btn' type='submit' name='id' value='" . $row["ID"] . "'>Delete</button></form></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>0 results</td></tr>";
}

// Close the connection
$conn->close();
?>
            </tbody>
        </table>
        <!-- Logout Button -->
        <div class="btn-container">
            <form method="post" action="index.html">
                <button class="btn" type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>