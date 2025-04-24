<?php
$email = $_GET['email'];
$token = $_GET['token'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
    <style>
        .verify-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            margin: 50px auto;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
        .verify-link {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background: rgb(80, 133, 33);
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="verify-box">
        <h2>Registration Successful!</h2>
        <p>Please click the link below to verify your email address:</p>
        <a href="home.php?token=<?php echo $token; ?>" class="verify-link">Verify Email</a>
    </div>
</body>
</html>