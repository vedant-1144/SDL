<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Mark all notifications as read
if (isset($_POST['mark_read'])) {
    $update_sql = "UPDATE notifications SET is_read = TRUE WHERE user_id = $user_id";
    $conn->query($update_sql);
}

// Fetch notifications
$sql = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
</head>
<body>
    <h2>Notifications</h2>
    <form method="POST" action="notifications.php">
        <input type="submit" name="mark_read" value="Mark all as read">
    </form>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($notif = $result->fetch_assoc()): ?>
                <li style="<?php echo $notif['is_read'] ? 'color:gray;' : 'font-weight:bold;'; ?>">
                    <?php echo htmlspecialchars($notif['content']); ?> - <em><?php echo $notif['created_at']; ?></em>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No notifications.</p>
    <?php endif; ?>
    <p><a href="news_feed.php">Back to News Feed</a> | <a href="logout.php">Logout</a></p>
</body>
</html>
