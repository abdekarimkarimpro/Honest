<?php
include 'db_connect.php';

// نستخدم مستخدم رقم 1 افتراضياً للتجربة
$user_id = 1; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    // 1. جلب سعر العمولة من قاعدة البيانات
    $sql = "SELECT commission FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $commission = $row['commission'];

        // 2. تحديث رصيد الفني
        $update_sql = "UPDATE users SET wallet = wallet + $commission WHERE id = $user_id";
        
        if ($conn->query($update_sql) === TRUE) {
            // جلب الرصيد الجديد لإرساله للواجهة
            $balance_sql = "SELECT wallet FROM users WHERE id = $user_id";
            $balance_res = $conn->query($balance_sql);
            $balance_row = $balance_res->fetch_assoc();
            
            echo json_encode([
                "status" => "success", 
                "message" => "تم الشراء! أضيفت $commission درهم لمحفظتك.",
                "new_balance" => $balance_row['wallet']
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "خطأ في التحديث"]);
        }
    }
}
$conn->close();
?>