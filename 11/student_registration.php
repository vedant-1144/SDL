<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    $sql = "INSERT INTO students (name, dob, email, phone, address) VALUES ('$name', '$dob', '$email', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        $message = "Student registered successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>
    <h1>Student Registration</h1>
    <?php if ($message != '') { echo "<p>$message</p>"; } ?>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <label>Address:</label><br>
        <textarea name="address"></textarea><br><br>

        <input type="submit" value="Register">
    </form>
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
