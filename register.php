<?php
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

// Retrieve data from form submission
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Perform SQL query to insert user into database
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "User registered successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
