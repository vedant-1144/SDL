<?php
include 'db.php';

$vehicle_number = $_POST['vehicle_number'];
$vehicle_type = $_POST['vehicle_type'];
$amount_paid = $_POST['amount_paid'];

$sql = "INSERT INTO toll_entries (vehicle_number, vehicle_type, amount_paid)
        VALUES ('$vehicle_number', '$vehicle_type', '$amount_paid')";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>