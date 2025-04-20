<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle sending friend request
if (isset($_POST['send_request'])) {
    $friend_username = $conn->real_escape_string($_POST['friend_username']);
    $sql = "SELECT id FROM users WHERE username='$friend_username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $friend = $result->fetch_assoc();
        $friend_id = $friend['id'];

        // Check if already friends or request pending
        $check_sql = "SELECT id FROM friends WHERE (user_id=$user_id AND friend_id=$friend_id) OR (user_id=$friend_id AND friend_id=$user_id)";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            $error = "Friend request already sent or you are already friends.";
        } else {
            $insert_sql = "INSERT INTO friends (user_id, friend_id, status) VALUES ($user_id, $friend_id, 'pending')";
            if ($conn->query($insert_sql) === TRUE) {
                $success = "Friend request sent.";
            } else {
                $error = "Error sending friend request: " . $conn->error;
            }
        }
    } else {
        $error = "User not found.";
    }
}

// Handle accepting friend request
if (isset($_POST['accept_request'])) {
    $request_id = intval($_POST['request_id']);
    $update_sql = "UPDATE friends SET status='accepted' WHERE id=$request_id AND friend_id=$user_id";
    if ($conn->query($update_sql) === TRUE) {
        $success = "Friend request accepted.";
    } else {
        $error = "Error accepting friend request: " . $conn->error;
    }
}

// Handle rejecting friend request
if (isset($_POST['reject_request'])) {
    $request_id = intval($_POST['request_id']);
    $delete_sql = "DELETE FROM friends WHERE id=$request_id AND friend_id=$user_id";
    if ($conn->query($delete_sql) === TRUE) {
        $success = "Friend request rejected.";
    } else {
        $error = "Error rejecting friend request: " . $conn->error;
    }
}

// Fetch incoming friend requests
$requests_sql = "SELECT f.id, u.username FROM friends f JOIN users u ON f.user_id = u.id WHERE f.friend_id=$user_id AND f.status='pending'";
$requests_result = $conn->query($requests_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Friend Requests</title>
</head>
<body>
    <h2>Friend Requests</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <h3>Send Friend Request</h3>
    <form method="POST" action="friend_requests.php">
        <label>Username:</label><br>
        <input type="text" name="friend_username" required>
        <input type="submit" name="send_request" value="Send Request">
    </form>

    <h3>Incoming Friend Requests</h3>
    <?php if ($requests_result->num_rows > 0): ?>
        <ul>
            <?php while($row = $requests_result->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($row['username']); ?>
                    <form method="POST" action="friend_requests.php" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="accept_request" value="Accept">
                        <input type="submit" name="reject_request" value="Reject">
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No incoming friend requests.</p>
    <?php endif; ?>

    <p><a href="news_feed.php">Back to News Feed</a> | <a href="logout.php">Logout</a></p>
</body>
</html>
