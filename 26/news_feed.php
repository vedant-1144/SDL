<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch posts from user and friends
$sql = "
SELECT p.id, p.user_id, p.content, p.created_at, u.username, u.profile_picture
FROM posts p
JOIN users u ON p.user_id = u.id
WHERE p.user_id = $user_id
OR p.user_id IN (
    SELECT friend_id FROM friends WHERE user_id = $user_id AND status = 'accepted'
    UNION
    SELECT user_id FROM friends WHERE friend_id = $user_id AND status = 'accepted'
)
ORDER BY p.created_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>News Feed</title>
</head>
<body>
    <h2>News Feed</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="profile.php">Profile</a> | <a href="friend_requests.php">Friend Requests</a> | <a href="post.php">Create Post</a> | <a href="logout.php">Logout</a></p>

    <?php if ($result->num_rows > 0): ?>
        <?php while($post = $result->fetch_assoc()): ?>
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <p><strong><?php echo htmlspecialchars($post['username']); ?></strong> <em><?php echo $post['created_at']; ?></em></p>
                <?php if ($post['profile_picture']): ?>
                    <img src="<?php echo htmlspecialchars($post['profile_picture']); ?>" alt="Profile Picture" width="50" style="vertical-align:middle;">
                <?php endif; ?>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <p>
                    <a href="like.php?post_id=<?php echo $post['id']; ?>">Like</a> |
                    <a href="comment.php?post_id=<?php echo $post['id']; ?>">Comments</a>
                </p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts to show.</p>
    <?php endif; ?>
</body>
</html>
