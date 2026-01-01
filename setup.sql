-- Run once as the MySQL/MariaDB root user (XAMPP: phpMyAdmin > SQL, or the mysql client).
CREATE USER IF NOT EXISTS 'quiz'@'localhost' IDENTIFIED BY 'quiz';
GRANT ALL PRIVILEGES ON `qz\_%`.* TO 'quiz'@'localhost';
CREATE DATABASE IF NOT EXISTS qz_store;
CREATE TABLE IF NOT EXISTS qz_store.progress (
  `user` VARCHAR(50) NOT NULL PRIMARY KEY,
  `data` LONGTEXT NOT NULL,
  `ts` BIGINT NOT NULL
);
FLUSH PRIVILEGES;
