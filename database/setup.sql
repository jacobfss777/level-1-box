-- Vulnerable Web Application Database Setup
-- Database: dcsc (Digital Cybersecurity Challenge)

-- Create database
CREATE DATABASE IF NOT EXISTS dcsc;
USE dcsc;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS secret;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS users;

-- Create users table
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create feedback table (vulnerable to SQL injection)
CREATE TABLE feedback (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    feedback TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create secret table (contains flag for Challenge 3)
CREATE TABLE secret (
    id INT(11) NOT NULL AUTO_INCREMENT,
    flag VARCHAR(255) NOT NULL,
    description TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert test user (joe:canyouf1ndm3)
-- Password is MD5 hashed
INSERT INTO users (username, password) VALUES 
('joe', 'cecb11c40eb9ec57904ab3168f71b707');

-- Insert flag into secret table
INSERT INTO secret (flag, description) VALUES 
('flag{93a4f912d658154486f2bd1b9162715f}', 'Congratulations! You found the secret flag through SQL injection!');

-- Insert additional decoy data
INSERT INTO secret (flag, description) VALUES 
('flag{decoy_flag_12345}', 'This is a decoy flag'),
('flag{another_fake_flag}', 'Keep looking!');

-- Display success message
SELECT 'Database setup completed successfully!' AS Status;
SELECT 'Tables created: users, feedback, secret' AS Info;
SELECT CONCAT('Test user created - Username: joe, Password: canyouf1ndm3') AS Credentials;
