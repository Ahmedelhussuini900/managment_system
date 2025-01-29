<?php
$servername = "localhost";
$username = "root"; // ضع اسم مستخدم قاعدة البيانات
$password = ""; // ضع كلمة المرور إذا كانت موجودة
$dbname = "managment_system"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>