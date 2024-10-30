CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT ON *.* TO 'newuser'@'localhost';
GRANT FILE ON *.* TO 'newuser'@'localhost';
FLUSH PRIVILEGES;

-- Tạo cơ sở dữ liệu nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS lab;

-- Sử dụng cơ sở dữ liệu vừa tạo
USE lab;

-- Tạo bảng users nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Chèn dữ liệu mẫu vào bảng users
INSERT INTO users (username, password) VALUES
('testuser', 'password123'),
('admin', 'admin'),
('user1', 'user1password');