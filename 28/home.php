<?php
$conn = new mysqli("localhost", "root", "", "phpmail");

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = $conn->query("SELECT * FROM users WHERE token = '$token'");
    $name = $result->fetch_assoc()['name'];
    echo "<h2>Welcome, $name</h2>"; 

    if ($result && $result->num_rows > 0) {
        $conn->query("UPDATE users SET is_verified = 1 WHERE token = '$token'");
        $message = "Email verified successfully!";
        $status = "success";
    } else {
        $message = "Invalid or expired token.";
        $status = "error";
    }
} else {
    $message = "No token provided.";
    $status = "error";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verification Status</title>
    <style>
        .success { color: rgb(80, 133, 33); }
        .error { color: #dc3545; }
    </style>
</head>
<body>
    <h2 class=" <?php echo $status; ?> "> <?php echo $message; ?> </h2>
    <a href="index.php">Return to Register</a>
</body>
</html>
