# NAME : BRIAN NDUNGU MUTURI REG NO: 3116.29 INSTITUTION: KENYA INSTITUTE OF SOFTWARE ENGINEERING AND PROFESSIONAL STUDIES

# Student Records Management System
Capstone Project for JP International Examination 

## Project Description

A web-based student records management system designed for educational institutions to efficiently manage student data and course information. Built with PHP and MySQL, this system provides separate dashboards for administrators and students with role-based access control, secure authentication, and comprehensive management tools.

## Problem Statement

Educational institutions face challenges in managing large volumes of student records and course information through traditional paper-based or scattered digital systems. This leads to:
- Inefficient data management and retrieval
- Difficulty tracking student progress and enrollment
- Lack of centralized course information
- Difficulty generating reports and analytics
- Security concerns with sensitive student data

This system addresses these issues by providing a centralized, secure platform for educational administrators to manage student records and courses efficiently, while allowing students to access their own information and course details.

## Core Features

**Authentication & Access Control:**
- Secure login system with username/password authentication
- User roles: Admin and Student with role-based access
- Password hashing and session management
- 30-minute inactivity timeout
- CSRF token validation

**Admin Dashboard:**
- 👥 Manage Students (view, add, edit, delete student records)
- 📚 Manage Courses (view, add, edit, delete courses)
- 📊 Reports (generate and view system reports)
- ⚙️ Settings (system configuration)

**Student Dashboard:**
- 📚 View enrolled courses
- 📝 Check grades
- 👤 Access profile settings

**Security Features:**
- SQL injection prevention (mysqli prepared statements)
- Password hashing with `password_verify()`
- Session regeneration after login
- CSRF protection on login form

---

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB
- **Frontend**: HTML5, CSS3
- **Security**: bcrypt password hashing, prepared statements, CSRF tokens
- **Server**: Apache / Nginx / Built-in PHP server

---

## Setup



1. Place the project in your web server document root (e.g., XAMPP `htdocs`).

2. Create a MySQL database named `student_project` and a `user` table with columns:

   - `id` INT AUTO_INCREMENT PRIMARY KEY

   - `username` VARCHAR(255) UNIQUE

   - `password` VARCHAR(255)

   - `usertype` ENUM('student','admin')



Example SQL:



```sql

CREATE DATABASE student_project;

USE student_project;



CREATE TABLE user (

  id INT AUTO_INCREMENT PRIMARY KEY,

  username VARCHAR(255) NOT NULL UNIQUE,

  password VARCHAR(255) NOT NULL,

  usertype ENUM('student','admin') NOT NULL

);



-- Insert admin with hashed password (replace PASSWORD_HERE)

INSERT INTO user (username, password, usertype) VALUES ('admin', '$2y$10$PASSWORD_HERE', 'admin');

```



Installation & Testing



**Prerequisites:**

- PHP 7.4+ with mysqli extension

- MySQL 5.7+ or MariaDB



**Windows (XAMPP):**

1. Copy project folder to `C:\xampp\htdocs\student`

2. Start MySQL and Apache from XAMPP Control Panel

3. Run the SQL script above in phpMyAdmin

4. Open http://localhost/student in your browser



**macOS/Linux:**

1. Copy project to a web-accessible directory

2. Start your web server (nginx, Apache, etc.)

3. Create database and run SQL script

4. Access http://localhost/student



**Quick test (built-in PHP server):**

```bash

cd /path/to/student

php -S localhost:8000 -t .

```

Then open http://localhost:8000 in your browser.



Security Features



- ✅ **Database**: Uses mysqli with prepared statements (SQL injection prevention)

- ✅ **Authentication**: Password hashing with `password_verify()`, legacy plaintext upgrade support

- ✅ **Session**: Regenerated after login, 30-minute inactivity timeout

- ✅ **CSRF**: Token validation on login form

- ✅ **Design**: Analogous indigo→blue→cyan color palette with modern spacing



Test Credentials (after setup):

- Admin: username `admin`, password should be hashed in the database

- Create students using the same table structure with `usertype='student'`



