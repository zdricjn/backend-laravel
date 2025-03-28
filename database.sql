-- 1. CREATE THE DATABASE
CREATE DATABASE project_manager;
USE project_manager;

-- 2. CREATE USERS TABLE (for login)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'user') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. CREATE PROJECTS TABLE
CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  description TEXT,
  status ENUM('pending', 'in-progress', 'completed') DEFAULT 'pending',
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. CREATE TASKS TABLE
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  status ENUM('pending', 'in-progress', 'completed') DEFAULT 'pending',
  due_date DATE,
  project_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 5. INSERT TEST DATA

-- Add admin user (password: "admin123")
INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Add regular user (password: "user123")
INSERT INTO users (name, email, password)  
VALUES ('Zedric Gasga', 'zedricgasga@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Add sample projects
INSERT INTO projects (title, description, status, user_id) VALUES
('Website Redesign', 'Redesign company website', 'in-progress', 1),
('Mobile App', 'Build new mobile application', 'pending', 2);

-- Add sample tasks
INSERT INTO tasks (name, description, status, due_date, project_id, user_id) VALUES
('Design Homepage', 'Create new homepage layout', 'completed', '2023-12-15', 1, 1),
('Develop API', 'Build backend API', 'in-progress', '2023-12-20', 1, 1),
('User Testing', 'Conduct usability tests', 'pending', '2024-01-10', 2, 2);

-- 6. VERIFY THE DATA

-- View all users
SELECT * FROM users;

-- View all projects with owner names
SELECT p.*, u.name AS owner 
FROM projects p
JOIN users u ON p.user_id = u.id;

-- View all tasks with project info
SELECT t.*, p.title AS project_name, u.name AS assigned_to
FROM tasks t
JOIN projects p ON t.project_id = p.id
JOIN users u ON t.user_id = u.id;