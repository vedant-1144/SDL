CREATE DATABASE book_store;

USE book_store;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100)
);

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  price DECIMAL(10, 2)
);

-- Sample data
INSERT INTO books (title, author, price) VALUES
('The Alchemist', 'Paulo Coelho', 299.99),
('Atomic Habits', 'James Clear', 399.50),
('1984', 'George Orwell', 199.00);
