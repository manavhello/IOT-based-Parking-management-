<?php
session_start();

// Check if the user is authenticated
if (isset($_SESSION['authenticated'])) {
    $response = array("authenticated" => true);
} else {
    $response = array("authenticated" => false);
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>