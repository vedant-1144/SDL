<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$error = '';
$success = '';

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $conn->real_escape_string($_POST['content']);
    if (empty($content)) {
        $error = "Comment cannot be empty.";
    } else {
        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES ($post_id, $user_id, '$content')";
        if ($conn->query($sql) === TRUE) {
            $success = "Comment added.";
        } else {
            $error = "Error adding comment: " . $conn->error;
        }
    }
}

// Fetch post details
$post_sql = "
SELECT p.id, p.content, p.created_at, u.username
FROM posts p
JOIN users u ON p.user_id = u.id
WHERE p.id = $post_id
";
$post_result = $conn->query($post_sql);
$post = $post_result->fetch_assoc();

// Fetch comments
$comments_sql = "
SELECT c.content, c.created_at, u.username
FROM comments c
JOIN users u ON c.user_id = u.id
WHERE c.post_id = $post_id
ORDER BY c.created_at ASC
";
$comments_result = $conn->query($comments_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comments</title>
</head>
<body>
    <h2>Comments for Post</h2>
    <?php if ($post): ?>
        <p><strong><?php echo htmlspecialchars($post['username']); ?></strong> said:</p>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        <p><em><?php echo $post['created_at']; ?></em></p>
    <?php else: ?>
        <p>Post not found.</p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="comment.php?post_id=<?php echo $post_id; ?>">
        <textarea name="content" rows="4" cols="50" placeholder="Add a comment..." required></textarea><br><br>
        <input type="submit" value="Comment">
    </form>

    <h3>All Comments</h3>
    <?php if ($comments_result->num_rows > 0): ?>
        <ul>
            <?php while($comment = $comments_result->fetch_assoc()): ?>
                <li><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['content'])); ?> <em>(<?php echo $comment['created_at']; ?>)</em></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>

    <p><a href="news_feed.php">Back to News Feed</a></p>
</body>
</html>
