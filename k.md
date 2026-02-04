# Student Project

Minimal student management demo.

Setup

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

Next Steps

- Add registration page with input validation
- Implement admin dashboard (manage students/courses)
- Add HTTPS enforcement and secure cookie flags (`HttpOnly`, `Secure`, `SameSite`)
- Email verification for password reset
