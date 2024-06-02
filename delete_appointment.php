<?php
session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Establish connection to MySQL database
$servername = "sql310.infinityfree.com";
$username = "if0_36462545";
$password = "Gurjar0966";
$dbname = "if0_36462545_hemant";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if appointment ID is provided in the URL
if (isset($_GET['id'])) {
    // Escape and sanitize appointment ID
    $appointment_id = $_GET['id'];

    // Prepare SQL statement to delete appointment
    $sql = "DELETE FROM appointments WHERE id='$appointment_id'";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Appointment deleted successfully, redirect to portal
        header("Location: portal.php");
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    // If appointment ID is not provided, redirect to portal
    header("Location: portal.php");
}

$conn->close();
?>
