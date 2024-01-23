<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'fe9aL';

// اتصال باستخدام mysqli_connect
$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// اتصال باستخدام mysqli
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "fe9aL";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>
