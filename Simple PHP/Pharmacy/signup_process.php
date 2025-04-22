<?php
include 'db.php';

$name = $_POST['name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Signup successful. <a href='login.php'>Login Now</a>";
} else {
    echo "Error: " . $conn->error;
}
?>