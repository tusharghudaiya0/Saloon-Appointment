<?php
session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

// Retrieve username and email from session
$usernames = $_SESSION['username'];
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
<title>Appointment Portal</title>
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
    .logout {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }
    .logout:hover {
        background-color: #0056b3;
    }
    .add-appointment {
        text-align: center;
        margin-bottom: 20px;
    }
    .add-appointment a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .add-appointment a:hover {
        background-color: #0056b3;
    }
    .customer-preview {
        text-align: center;
        margin-bottom: 20px;
    }
    .customer-preview a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .customer-preview a:hover {
        background-color: #0056b3;
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
    <h1>Welcome, <?php echo $usernames; ?>!</h1>
    <a href="logout.php" class="logout">Logout</a>
    
    <div class="add-appointment">
        <a href="add_appointment_form.php">Add Appointment</a>
    </div>

    <div class="customer-preview">
        <a href="customer_preview.php" class="button">Customer Preview</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo $appointment['name']; ?></td>
                <td><?php echo $appointment['date']; ?></td>
                <td><?php echo $appointment['time']; ?></td>
                <td><?php echo $appointment['mobile']; ?></td>
                <td>
                    <a href="delete_appointment.php?id=<?php echo $appointment['id']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

</body>
</html>
