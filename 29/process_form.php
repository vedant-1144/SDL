<?php
// Include database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form inputs
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Simple validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Here you could insert data into a database table if desired
        // For simplicity, just display a success message

        $response = "Thank you, " . htmlspecialchars($name) . ". Your message has been received.";
    } else {
        $response = "Please fill in all fields.";
    }
} else {
    // Redirect to form if accessed directly
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Submission Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
        .message {
            margin-top: 20px;
            padding: 15px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 4px;
            font-size: 18px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #337ab7;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Submission Result</h1>
        <div class="message"><?php echo $response; ?></div>
        <a href="index.php">Back to form</a>
    </div>
</body>
</html>
