<?php
session_start();

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

// Retrieve email and password from form submission
$email = $_POST['email'];
$password = $_POST['password'];

// Perform SQL query to check if user exists
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User exists and password is correct, retrieve username
    $row = $result->fetch_assoc();
    $username = $row['username'];
    
    // Start session and store username in session variable
    $_SESSION['username'] = $usernames;
    $_SESSION['email'] = $email;
    // Redirect to portal
    header("Location: portal.php");
} else {
    // Invalid login, redirect back to login page with error message
    header("Location: login.html?error=1");
}

$conn->close();
?>
