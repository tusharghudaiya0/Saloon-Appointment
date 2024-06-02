<?php
// Fetch the current date and time in Kolkata, India using WorldTimeAPI
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://worldtimeapi.org/api/timezone/Asia/Kolkata",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $data = json_decode($response, true);
  
  // Extract the current date and time
  $current_datetime = isset($data['datetime']) ? $data['datetime'] : "Unknown";
  
  // Convert to datetime object
  $datetime_obj = new DateTime($current_datetime);

  // Format the current date and time separately
  $current_date = $datetime_obj->format('F j, Y');
  $current_time = $datetime_obj->format('g:i a');
}
?>

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

// Retrieve current user's email from session
$user_email = $_SESSION['email']; // Assuming the email is stored in session

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve appointment details from form submission
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $date = $current_date; // Use current date
    $time = $current_time; // Use current time

    // Perform SQL query to insert appointment into database
    $sql = "INSERT INTO appointments (name, mobile, date, time, user_email) VALUES ('$name', '$mobile', '$date', '$time', '$user_email')";

    if ($conn->query($sql) === TRUE) {
        // Appointment added successfully, redirect to appointment portal page
        header("Location: portal.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Appointment</title>
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
    h2 {
        text-align: center;
        color: #333;
    }
    form {
        margin-top: 20px;
        text-align: center;
    }
    label {
        display: block;
        margin-bottom: 10px;
    }
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
    input[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .buttons {
        margin-top: 20px;
        text-align: center;
    }
    .buttons a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        margin-right: 10px;
    }
    .buttons a:last-child {
        margin-right: 0;
    }
    .buttons a:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Add Appointment</h2>
    <p>Current Date in Kolkata, India: <?php echo $current_date; ?></p>
    <p>Current Time in Kolkata, India: <?php echo $current_time; ?></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="mobile">Mobile Number:</label>
        <input type="text" id="mobile" name="mobile" required><br>
        <label>Date: </label>
        <input type="text" name="date" value="<?php echo $current_date; ?>" readonly><br>
        <label>Time: </label>
        <input type="text" name="time" value="<?php echo $current_time; ?>" readonly><br>
        <input type="submit" value="Submit">
    </form>
    <div class="buttons">
        <a href="portal.php">Back</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
