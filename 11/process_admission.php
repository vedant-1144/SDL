<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = intval($_POST['application_id']);
    $decision = $_POST['decision'];

    // Update application status
    $sql_update = "UPDATE applications SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $decision, $application_id);
    $stmt->execute();
    $stmt->close();

    // If accepted, insert into admissions table
    if ($decision === 'Accepted') {
        $sql_check = "SELECT * FROM admissions WHERE application_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $application_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 0) {
            $sql_insert = "INSERT INTO admissions (application_id, admission_date, status) VALUES (?, NOW(), 'Confirmed')";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("i", $application_id);
            $stmt_insert->execute();
            $stmt_insert->close();
        }
        $stmt_check->close();
    }

    $message = "Admission decision updated successfully.";
}

// Fetch pending applications
$sql = "SELECT applications.id, students.name AS student_name, courses.name AS course_name, applications.application_date, applications.status
        FROM applications
        JOIN students ON applications.student_id = students.id
        JOIN courses ON applications.course_id = courses.id
        WHERE applications.status = 'Pending'
        ORDER BY applications.application_date ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Process Admissions</title>
</head>
<body>
    <h1>Process Admissions</h1>
    <?php if ($message != '') { echo "<p>$message</p>"; } ?>
    <?php if ($result->num_rows > 0) { ?>
    <form method="POST" action="">
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Course Name</th>
                <th>Application Date</th>
                <th>Status</th>
                <th>Decision</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                <td><?php echo $row['application_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                    <select name="decision" required>
                        <option value="">Select</option>
                        <option value="Accepted">Accept</option>
                        <option value="Rejected">Reject</option>
                    </select>
                </td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <input type="submit" value="Submit Decisions">
    </form>
    <?php } else { ?>
        <p>No pending applications to process.</p>
    <?php } ?>
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
