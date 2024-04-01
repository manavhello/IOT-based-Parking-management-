<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
            overflow-x: auto; /* Add horizontal scrolling if needed */
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

        /* Center content */
        .center-content {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Dashboard</h1>
        <p class="center-content">Welcome to the User Dashboard!</p>
        <table>
            <thead>
                <tr>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Slot Number</th>
                    <th>Date Details</th>
                    <th>Time Details</th>
                    <th>Time Duration</th>
                    <th>Action</th> <!-- New column for action -->
                </tr>
            </thead>
            <tbody>
            <?php
            session_start(); // Start the session
            if (!isset($_SESSION['authenticated'])) {
                // Redirect the user to the login page if not logged in
                header("Location: index.html");
                exit(); // Stop executing the rest of the code
            }
            $username = $_SESSION['username']; // Fetch the username from the session
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
            $sql = "SELECT VehicleType, VehicleNumber, SlotNumber, date_details, time_details, time_duration FROM user WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['slotNumber'] = $row["SlotNumber"]; // Store SlotNumber in session variable
                    echo "<tr>";
                    echo "<td>" . $row["VehicleNumber"] . "</td>";
                    echo "<td>" . $row["VehicleType"] . "</td>";
                    echo "<td>" . $row["SlotNumber"] . "</td>";
                    echo "<td>" . $row["date_details"] . "</td>";
                    echo "<td>" . $row["time_details"] . "</td>";
                    echo "<td>" . $row["time_duration"] . "</td>";
                    // Adding payment button with a link to payment page
                    echo "<td><a href='payment.php' class='btn'>Generate bill</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No results found</td></tr>";
            }

            // Close the connection
            $conn->close();
            ?>
            </tbody>
        </table>
        <!-- Logout Button -->
        <div class="btn-container">
            <form method="post" action="home.html">
                <button class="btn" type="submit">Exit</button>
            </form>
        </div>
    </div>
    <p class="center-content"><strong>Hello:</strong> <span id="user-name"><?php echo $username; ?></span></p>
</body>
</html>
