CREATE DATABASE IF NOT EXISTS scorpio;

USE scorpio;

CREATE TABLE IF NOT EXISTS accounts ( 
  id SERIAL PRIMARY KEY,  
  name VARCHAR(255) UNIQUE, 
  email VARCHAR(255) UNIQUE,
  email_validated BOOLEAN DEFAULT FALSE,
  permission VARCHAR(50) NOT NULL,
  psw_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS profiles ( 
  id SERIAL PRIMARY KEY,  
  fname VARCHAR(255) NOT NULL, 
  lname VARCHAR(255) NOT NULL,  
  avatar VARCHAR(255),
  acc_id BIGINT UNSIGNED,
  FOREIGN KEY (acc_id) REFERENCES accounts(id)
);


CREATE TABLE `posts` (
  `id` SERIAL PRIMARY KEY,
  `title` varchar(255),
  `slug` varchar(255),
  `status` enum('drafts','published','archived') NOT NULL,
  `date_at` VARCHAR(50),
  `author` varchar(255) NOT NULL,
  `avatar` VARCHAR(255),
  `img_landscape` varchar(255),
  `img_portrait` varchar(255),
  `description` TEXT,
  `content` LONGTEXT,
  `acc_id` BIGINT UNSIGNED,
  FOREIGN KEY (acc_id) REFERENCES accounts(id)
);
