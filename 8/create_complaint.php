<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $complaint = $conn->real_escape_string($_POST['complaint']);

    $sql = "INSERT INTO complaints (name, email, complaint, status, created_at) VALUES ('$name', '$email', '$complaint', 'Pending', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Complaint submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
