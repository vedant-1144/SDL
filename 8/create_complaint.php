<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $complaint = $_POST['complaint'];

    $sql = "INSERT INTO complaints (name, email, complaint, status, created_at) VALUES ('$name', '$email', '$complaint', 'Pending', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>