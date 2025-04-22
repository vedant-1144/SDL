<?php
include 'db.php';

$id = $_POST['id'];
$vehicle_number = $_POST['vehicle_number'];
$vehicle_type = $_POST['vehicle_type'];
$amount_paid = $_POST['amount_paid'];

$sql = "UPDATE toll_entries SET vehicle_number='$vehicle_number', vehicle_type='$vehicle_type', amount_paid='$amount_paid' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>