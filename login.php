<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Admin</title>
</head>
<body>
<?php

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST["password"];

        if ($password === "WeKnowTheGame23") {
            $_SESSION["logged_in"] = true;
            header("Location: admin.php");
            exit();
        } else {
            echo "Incorrect password: please try again.";
        }
    }
?>
<div class="header">
    <h1>Admin Login</h1>
</div>
<div class="password">
    <form method="post" action="login.php">
        <p>Admin Password:</p>
        <input type="password" name="password"> <input type="submit">
    </form>
</div>


<div class="home">
    <a href="index.php" type="button">⌂</a>
</div>


</body>