CREATE DATABASE school_db;

USE school_db;

CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    class_id INT,
    image VARCHAR(255),
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE SET NULL
);
