<!DOCTYPE html>
<html>
<head><title>Signup</title></head>
<body>
    <h2>Signup</h2>
    <form method="post" action="signup_process.php">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Sign Up">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
