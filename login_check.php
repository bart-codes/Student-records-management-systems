<?php

error_reporting(0);
session_start();

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate CSRF token
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $_SESSION['loginMessage'] = 'Invalid request (CSRF token mismatch).';
        header('Location: login.php');
        exit();
    }
    $name = isset($_POST['username']) ? trim($_POST['username']) : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

    if ($name === '' || $pass === '') {
        $_SESSION['loginMessage'] = 'Please provide username and password.';
        header('Location: login.php');
        exit();
    }

    $stmt = $conn->prepare('SELECT id, username, password, usertype FROM user WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored = $row['password'];

        $authenticated = false;

        if (password_verify($pass, $stored)) {
            $authenticated = true;
        } elseif ($stored === $pass) {
            // Legacy plaintext password: upgrade to hashed password
            $newhash = password_hash($pass, PASSWORD_DEFAULT);
            $up = $conn->prepare('UPDATE user SET password = ? WHERE id = ?');
            $up->bind_param('si', $newhash, $row['id']);
            $up->execute();
            $authenticated = true;
        }

        if ($authenticated) {
            session_regenerate_id(true);
            $_SESSION['username'] = $row['username'];
            $_SESSION['usertype'] = $row['usertype'];
            // Clear CSRF token after successful login
            unset($_SESSION['csrf_token']);
            if ($row['usertype'] === 'student') {
                header('Location: studenthome.php');
                exit();
            } elseif ($row['usertype'] === 'admin') {
                header('Location: adminhome.php');
                exit();
            }
        }
    }

    $_SESSION['loginMessage'] = 'Username or password do not match';
    header('Location: login.php');
    exit();
}

?>