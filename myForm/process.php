<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="form-container">
        <h2>Form Submission Result</h2>

       <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = 'localhost';
$dbname = 'form_data';
$username = 'root';
$password = 'root';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare the SQL insert statement
    $sql = "INSERT INTO submissions (name, email, message) VALUES (?, ?, ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        header("Location: thankyou.php");
        exit();
    } else {
        echo "<p>Error saving data: " . $stmt->error . "</p>";
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>


        <a href="index.php">Go back to the form</a>
    </div>

</body>
</html>