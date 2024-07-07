<?php

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "db_hotelresv";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
