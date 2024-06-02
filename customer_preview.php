<?php
session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Retrieve username and email from session
$username = $_SESSION['username'];
$email = $_SESSION['email'];

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

// Perform SQL query to fetch appointments associated with the user's email
$sql = "SELECT * FROM appointments WHERE user_email='$email' ORDER BY time";
$result = $conn->query($sql);

// Check if appointments are found
if ($result->num_rows > 0) {
    // Appointments found, store them in an array
    $appointments = array();
    while($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
} else {
    // No appointments found
    $appointments = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Preview</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Welcome to <?php echo $_SESSION['username']; ?>!</h1>
    
    <table>
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $appointment['name']; ?></td>
                <td><?php echo $appointment['date']; ?></td>
                <td><?php echo $appointment['time']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
