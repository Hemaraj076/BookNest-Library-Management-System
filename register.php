<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$role = trim($_POST['role'] ?? '');
$name = trim($_POST['name'] ?? ''); $roll = trim($_POST['roll'] ?? ''); $department = trim($_POST['department'] ?? '');
$mobile = trim($_POST['mobile'] ?? ''); $email = trim($_POST['email'] ?? ''); $plain = $_POST['password'] ?? '';
if (!in_array($role, ['student','faculty','admin'], true) || $name === '' || $roll === '' || $department === '' || !filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match('/^[6-9][0-9]{9}$/',$mobile) || strlen($plain) < 8) { header('Location:index.php?error=db'); exit; }
foreach ([['roll_no',$roll,'roll'],['mobile',$mobile,'mobile'],['email',$email,'email']] as [$col,$val,$err]) {
  $stmt=$conn->prepare("SELECT id FROM members WHERE $col=? LIMIT 1"); $stmt->bind_param('s',$val); $stmt->execute(); $stmt->store_result();
  if($stmt->num_rows>0){ $stmt->close(); header("Location:index.php?error=$err"); exit; } $stmt->close();
}
$hash=password_hash($plain,PASSWORD_DEFAULT);
$stmt=$conn->prepare('INSERT INTO members (full_name,roll_no,department,mobile,email,password,role) VALUES (?,?,?,?,?,?,?)');
$stmt->bind_param('sssssss',$name,$roll,$department,$mobile,$email,$hash,$role);
if($stmt->execute()){ $stmt->close(); header('Location:login.php?registered=1'); exit; }
$stmt->close(); header('Location:index.php?error=db'); exit;
