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


CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('draft','published','archived') NOT NULL,
  `author` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `content` longtext NOT NULL
);

INSERT INTO `posts` (`id`, `title`, `slug`, `status`, `author`, `img`, `content`) VALUES (NULL, 'Test one draft version', 'test-one-draft-version', 'draft', 'kribo', '', 'THIS IS TEST ONE '), (NULL, 'Test two publised version', 'test-two-published-version', 'published', 'kribo', '', 'THIS IS TEST TWO ');
