<?php
session_start();
if (isset($_POST['txtusr']) && isset($_POST['txtpwd'])) {
    $usr = $_POST['txtusr'];
    $pwd = $_POST['txtpwd'];
    if ($usr == "Mani" && $pwd == "M@ni123") {
        $_SESSION['usr'] = $usr;
        header("Location: home.php");
    } else {
        echo "Invalid Username/Password";
    }
}
?>