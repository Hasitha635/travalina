<?php
$host = "localhost";
$user = "root";   // default WAMP user
$pass = "";       // default WAMP password is empty
$dbname = "travelina";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
