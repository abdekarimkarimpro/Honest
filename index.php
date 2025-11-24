<?php
include 'db_connect.php';

// جلب بيانات الفني رقم 1
$user_sql = "SELECT * FROM users WHERE id = 1";
$user_res = $conn->query($user_sql);
$user = $user_res->fetch_assoc();

// جلب المنتجات
$products_sql = "SELECT * FROM products";
$products_res = $conn->query($products_sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سات فيكس | لوحة الفني</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans pb-10">

    <!-- Navbar -->
    <nav class="bg-blue-900 text-white p-4 shadow sticky top-0 z-50">
        <div class="flex justify-between items-center max-w-2xl mx-auto">
            <h1 class="text-xl font-bold">📡 سات فيكس</h1>
            <span class="text-sm bg-blue-800 px-3 py-1 rounded-full">👤 <?php echo $user['name']; ?></span>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto p-4 mt-4">
        
        <!-- المحفظة -->
        <div class="bg-white p-6 rounded-2xl shadow-lg border-r-8 border-green-500 mb-8 text-center">
            <h3 class="text-gray-500 font-bold text-sm">💰 رصيد الأرباح الحالي</h3>
            <div class="flex justify-center items-end gap-2 mt-2">
                <span id="wallet-display" class="text-4xl font-black text-gray-800"><?php echo $user['wallet']; ?></span>
                <span class="text-gray-600 font-bold mb-1">درهم</span>
            </div>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📦 المنتجات المتوفرة للشراء</h2>

        <!-- قائمة المنتجات -->
        <div class="space-y-4">
            <?php
            if ($products_res->num_rows > 0) {
                while($product = $products_res->fetch_assoc()) {
            ?>
                <!-- كارت المنتج -->
                <div class="bg-white rounded-xl shadow overflow-hidden flex flex-col md:flex-row">
                    <img src="<?php echo $product['image_url']; ?>" class="w-full md:w-32 h-40 object-cover">
                    <div class="p-4 flex-1">
                        <h3 class="font-bold text-lg text-gray-800"><?php echo $product['name']; ?></h3>
                        
                        <div class="flex justify-between items-center mt-3">
                            <div>
                                <span class="text-xs text-gray-400">السعر للزبون</span>
                                <div class="text-blue-900 font-bold text-xl"><?php echo $product['price']; ?> د.م</div>
                            </div>
                            <div class="bg-green-100 px-3 py-1 rounded-lg text-center">
                                <span class="text-[10px] text-green-800 font-bold block">عمولتك</span>
                                <span class="text-green-700 font-bold text-lg">+<?php echo $product['commission']; ?></span>
                            </div>
                        </div>

                        <button onclick="buyNow(<?php echo $product['id']; ?>)" class="w-full bg-blue-900 text-white mt-4 py-2 rounded-lg font-bold shadow hover:bg-blue-800 transition transform active:scale-95">
                            🛒 شراء وحساب العمولة
                        </button>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<p class='text-center text-gray-500'>لا توجد منتجات حالياً</p>";
            }
            ?>
        </div>
    </div>

    <!-- JavaScript للربط مع السيرفر -->
    <script>
        function buyNow(productId) {
            if(confirm("تأكيد عملية الشراء؟")) {
                // إرسال طلب للسيرفر بدون تحديث الصفحة
                let formData = new FormData();
                formData.append('product_id', productId);

                fetch('buy_action.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        alert("✅ " + data.message);
                        // تحديث الرصيد في الشاشة
                        document.getElementById('wallet-display').innerText = data.new_balance;
                    } else {
                        alert("❌ خطأ: " + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>

</body>
</html>