CREATE DATABASE IF NOT EXISTS blogdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blogdb;

-- users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- categories
CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  slug VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- posts
CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  summary TEXT NOT NULL,
  content LONGTEXT,
  image VARCHAR(255),
  category_id INT NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME DEFAULT NULL,
  author VARCHAR(100),
  CONSTRAINT fk_post_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--  usuario admin (hash de "Admin123!")
INSERT INTO users (email, password, name) VALUES
('admin@example.com', '$2y$10$WbcRI2D0oAbcRQxQXkv0uOyUovzS8FJcWc57N3Flr5P2B6s5rjKwi', 'Admin');

--  categories
INSERT INTO categories (name, slug) VALUES
('Technology','technology'),
('Design','design'),
('UX','ux');

-- ejemplos
INSERT INTO posts (title, summary, content, image, category_id, created_at, author) VALUES
('Primer post de prueba','Resumen corto de prueba','Contenido de ejemplo','/uploads/sample1.jpg',1,'2025-09-29 10:00:00','Admin'),
('Segundo post','Resumen 2','Contenido 2','/uploads/sample2.jpg',2,'2025-09-28 12:00:00','Admin');
