-- Create the database
CREATE DATABASE IF NOT EXISTS test_db;

-- Use the database
USE test_db;

-- Create the 'items' table
CREATE TABLE IF NOT EXISTS items (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Insert sample data
INSERT INTO items (name, description)
VALUES
    ('Item 1', 'Description for Item 1'),
    ('Item 2', 'Description for Item 2'),
    ('Item 3', 'Description for Item 3');

-- Select all data from the table
SELECT * FROM items;
