<!DOCTYPE html>
<html>
<head>
    <title>Complaint Management System</title>
</head>
<body>
    <h1>Submit a Complaint</h1>
    <form action="create_complaint.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="complaint">Complaint:</label><br>
        <textarea id="complaint" name="complaint" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Submit Complaint">
    </form>
    <br>
    <a href="view_complaints.php">View Complaints</a>
</body>
</html>
