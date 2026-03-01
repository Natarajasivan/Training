<?php
session_start();
if (!isset($_SESSION['usr'])) {
    header("Location: index.html");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Successful</title>
    <link type="text/css" rel="stylesheet" href="css/site.css">
</head>

<body>
    <header>
        <h1>Welcome
            <?php echo $_SESSION['usr']; ?>
        </h1>
    </header>
    <hr>
    <form action="logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
    <footer>
        Developed by K Anbarasan
    </footer>
</body>

</html>