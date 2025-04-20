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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $conn->real_escape_string($_POST['content']);
    if (empty($content)) {
        $error = "Post content cannot be empty.";
    } else {
        $sql = "INSERT INTO posts (user_id, content) VALUES ($user_id, '$content')";
        if ($conn->query($sql) === TRUE) {
            $success = "Post created successfully.";
        } else {
            $error = "Error creating post: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>
    <h2>Create a New Post</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="post.php">
        <textarea name="content" rows="5" cols="50" placeholder="What's on your mind?" required></textarea><br><br>
        <input type="submit" value="Post">
    </form>

    <p><a href="news_feed.php">Back to News Feed</a> | <a href="logout.php">Logout</a></p>
</body>
</html>
