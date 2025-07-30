<?php

echo "Using updated db_connection.php<br>";

$host = "localhost";
$username = "u532311106_enrollment_1_4";
$password = "d]8XT+~j"; // Replace this
$dbname = "u532311106_enrollment_1_4";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
    