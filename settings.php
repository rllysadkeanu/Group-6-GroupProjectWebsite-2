<?php
$host = "localhost";
$user = "root";
$pwd = ""; // Default XAMPP has no password
$sql_db = "eoi_db"; // Make sure to create this database in phpMyAdmin

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
