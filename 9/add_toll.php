<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_number = $conn->real_escape_string($_POST['vehicle_number']);
    $vehicle_type = $conn->real_escape_string($_POST['vehicle_type']);
    $toll_booth_id = intval($_POST['toll_booth']);
    $amount = floatval($_POST['amount']);

    // Check if vehicle exists
    $sql = "SELECT id FROM vehicles WHERE vehicle_number = '$vehicle_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Vehicle exists
        $row = $result->fetch_assoc();
        $vehicle_id = $row['id'];
    } else {
        // Insert new vehicle
        $sql = "INSERT INTO vehicles (vehicle_number, vehicle_type) VALUES ('$vehicle_number', '$vehicle_type')";
        if ($conn->query($sql) === TRUE) {
            $vehicle_id = $conn->insert_id;
        } else {
            die("Error inserting vehicle: " . $conn->error);
        }
    }

    // Insert toll transaction
    $sql = "INSERT INTO toll_transactions (vehicle_id, toll_booth_id, amount) VALUES ($vehicle_id, $toll_booth_id, $amount)";
    if ($conn->query($sql) === TRUE) {
        echo "Toll transaction recorded successfully.";
        echo "<br><a href='index.php'>Add another transaction</a>";
        echo "<br><a href='view_tolls.php'>View all transactions</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.";
}
?>
