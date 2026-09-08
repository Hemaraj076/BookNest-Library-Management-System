<?php
session_start();
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: login.php'); exit; }
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') { header('Location: login.php?error=1'); exit; }
$stmt = $conn->prepare('SELECT id,full_name,email,department,password,role FROM members WHERE email=? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['full_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['department'] = $row['department'];
        $_SESSION['role'] = $row['role'] ?: 'student';
        header('Location: dashboard.php'); exit;
    }
}
$stmt->close();
header('Location: login.php?error=1'); exit;
