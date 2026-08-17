CREATE DATABASE IF NOT EXISTS yazzea_db;

USE yazzea_db;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);


CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE,

    FOREIGN KEY (product_id)
    REFERENCES products(id)
    ON DELETE CASCADE
);


INSERT INTO users
(fullname, username, password, role)
VALUES
('Yazzea Admin', 'admin', 'admin123', 'admin');


INSERT INTO products
(name, category, price, quantity, description)
VALUES
('Lavender Mist', 'Beauty', 199.00, 20,
'A refreshing lavender body mist.'),

('Purple Tote Bag', 'Bags', 299.00, 15,
'A simple and cute everyday tote bag.'),

('Yazzea Candle', 'Home', 149.00, 25,
'A relaxing scented candle.'),

('Purple Lip Gloss', 'Beauty', 250.00, 30,
'A cute purple lip gloss.'),

('Yazzea Bracelet', 'Accessories', 179.00, 18,
'A simple and elegant bracelet.');




this is how to put image

ALTER TABLE products
ADD image VARCHAR(255) DEFAULT NULL;


UPDATE products
SET image = 'bracelet.jpg'
WHERE name = 'Yazzea Bracelet';
