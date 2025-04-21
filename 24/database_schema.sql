CREATE DATABASE ecommerce;

USE ecommerce;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  price DECIMAL(10, 2),
  description TEXT
);

INSERT INTO products (name, price, description) VALUES
('Wireless Mouse', 599.00, 'Smooth and responsive mouse.'),
('Mechanical Keyboard', 1499.00, 'Backlit keys, great for typing.'),
('USB-C Cable', 199.00, 'Fast charging and data transfer.');
