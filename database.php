<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_register";
$con = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$con) {
    die("Something went wrong;");
}

?>