-- Student Management Database Schema

CREATE DATABASE IF NOT EXISTS student_project;
USE student_project;

-- User table (existing)
CREATE TABLE IF NOT EXISTS user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  usertype ENUM('student','admin') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Courses table
CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_name VARCHAR(255) NOT NULL,
  course_code VARCHAR(50) UNIQUE NOT NULL,
  description TEXT,
  instructor_name VARCHAR(255),
  credits INT DEFAULT 3,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Enrollments table (student-course relationship)
CREATE TABLE IF NOT EXISTS enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  course_id INT NOT NULL,
  enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('active','completed','dropped') DEFAULT 'active',
  FOREIGN KEY (student_id) REFERENCES `user`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES `courses`(`id`) ON DELETE CASCADE,
  UNIQUE KEY unique_enrollment (student_id, course_id)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Grades table
CREATE TABLE IF NOT EXISTS grades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  enrollment_id INT NOT NULL,
  assignment_name VARCHAR(255),
  score DECIMAL(5,2),
  max_score DECIMAL(5,2) DEFAULT 100,
  grade_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (enrollment_id) REFERENCES `enrollments`(`id`) ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data
INSERT INTO user (username, password, usertype) VALUES 
('admin', '$2y$12$E5M76meapWFNdbzx/QGlXO47ngRlI7rcLFMIHNiDqAfKunieJKWYe', 'admin'),
('student', '$2y$12$Yb7li1JyCOREfAptmuLiAeRb/17/gWHT1XjVczyeU.jYL5UF2.ZXO', 'student')
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO courses (course_name, course_code, description, instructor_name, credits) VALUES
('Introduction to Web Development', 'WEB101', 'Learn HTML, CSS, and JavaScript', 'John Smith', 3),
('Database Design', 'DB201', 'Master SQL and database concepts', 'Jane Doe', 4),
('Graphics & Design', 'GFX301', 'Adobe Creative Suite fundamentals', 'Mike Johnson', 3)
ON DUPLICATE KEY UPDATE course_name=course_name;
