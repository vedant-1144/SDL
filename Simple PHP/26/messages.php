<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$chat_with = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$error = '';

// Handle sending message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $chat_with > 0) {
    $content = $conn->real_escape_string($_POST['content']);
    if (!empty($content)) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES ($user_id, $chat_with, '$content')";
        if (!$conn->query($sql)) {
            $error = "Error sending message: " . $conn->error;
        }
    }
}

// Fetch users for chat list
$users_sql = "SELECT id, username FROM users WHERE id != $user_id";
$users_result = $conn->query($users_sql);

// Fetch chat messages
$messages = [];
if ($chat_with > 0) {
    $chat_sql = "
    SELECT m.sender_id, m.receiver_id, m.content, m.created_at, u.username
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE (m.sender_id = $user_id AND m.receiver_id = $chat_with)
       OR (m.sender_id = $chat_with AND m.receiver_id = $user_id)
    ORDER BY m.created_at ASC
    ";
    $chat_result = $conn->query($chat_sql);
    if ($chat_result) {
        while ($row = $chat_result->fetch_assoc()) {
            $messages[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
</head>
<body>
    <h2>Messages</h2>
    <p><a href="news_feed.php">Back to News Feed</a> | <a href="logout.php">Logout</a></p>

    <h3>Users</h3>
    <ul>
        <?php while ($user = $users_result->fetch_assoc()): ?>
            <li>
                <a href="messages.php?user_id=<?php echo $user['id']; ?>">
                    <?php echo htmlspecialchars($user['username']); ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php if ($chat_with > 0): ?>
        <h3>Chat with <?php
            $chat_user_sql = "SELECT username FROM users WHERE id = $chat_with";
            $chat_user_result = $conn->query($chat_user_sql);
            $chat_user = $chat_user_result->fetch_assoc();
            echo htmlspecialchars($chat_user['username']);
        ?></h3>

        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:scroll;">
            <?php foreach ($messages as $msg): ?>
                <p><strong><?php echo htmlspecialchars($msg['username']); ?>:</strong> <?php echo nl2br(htmlspecialchars($msg['content'])); ?> <em>(<?php echo $msg['created_at']; ?>)</em></p>
            <?php endforeach; ?>
        </div>

        <form method="POST" action="messages.php?user_id=<?php echo $chat_with; ?>">
            <textarea name="content" rows="3" cols="50" placeholder="Type your message..." required></textarea><br><br>
            <input type="submit" value="Send">
        </form>
    <?php endif; ?>
</body>
</html>
