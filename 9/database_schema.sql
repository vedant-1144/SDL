-- SQL script to create the database and tables for Toll Tax Management System

CREATE DATABASE IF NOT EXISTS toll_tax_management;
USE toll_tax_management;

CREATE TABLE IF NOT EXISTS toll_booths (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_number VARCHAR(50) NOT NULL UNIQUE,
    vehicle_type VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS toll_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    toll_booth_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id),
    FOREIGN KEY (toll_booth_id) REFERENCES toll_booths(id)
);
