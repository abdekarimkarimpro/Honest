<?php
$servername = "localhost";
$username = "root";    // غيّر هذا باسم مستخدم قاعدة البيانات في استضافتك
$password = "";        // غيّر هذا بكلمة المرور
$dbname = "satfix_db"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// دعم اللغة العربية
$conn->set_charset("utf8mb4");

// التحقق من الخطأ
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>