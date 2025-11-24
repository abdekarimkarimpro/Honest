-- إنشاء جدول المستخدمين
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    wallet DECIMAL(10, 2) DEFAULT 0.00
);

-- إنشاء جدول المنتجات
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    commission DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255) DEFAULT 'https://via.placeholder.com/150'
);

-- إضافة بيانات تجريبية (فني ومنتجات)
INSERT INTO users (name, wallet) VALUES ('أحمد الفني', 0.00);

INSERT INTO products (name, price, commission, image_url) VALUES 
('رسيفر Echolink HD', 250.00, 50.00, 'https://m.media-amazon.com/images/I/61H+1n+2O2L.jpg'),
('لاقط LNB 4 مخارج', 60.00, 20.00, 'https://m.media-amazon.com/images/I/51pQv+k-GHL.jpg'),
('كابل ستلايت (لفة 100م)', 120.00, 15.00, 'https://m.media-amazon.com/images/I/41D2KkF0eEL.jpg');