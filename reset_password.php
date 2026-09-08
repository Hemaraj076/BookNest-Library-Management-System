<?php
session_start();
include 'db.php';
if (isset($_SESSION['id'])) { header('Location: dashboard.php'); exit; }
$email = $_SESSION['reset_email'] ?? '';
$hash = $_SESSION['reset_otp_hash'] ?? '';
$expires = (int)($_SESSION['reset_otp_expires'] ?? 0);
$error = '';
if ($email === '' || $hash === '' || $expires < time()) { header('Location: forgot_password.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');
    $new = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!preg_match('/^\d{6}$/', $otp) || !password_verify($otp, $hash)) $error = 'Invalid OTP.';
    elseif ($expires < time()) $error = 'OTP expired. Generate a new OTP.';
    elseif (strlen($new) < 8) $error = 'Password must contain at least 8 characters.';
    elseif ($new !== $confirm) $error = 'Passwords do not match.';
    else {
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE members SET password=? WHERE email=? LIMIT 1');
        $stmt->bind_param('ss', $newHash, $email);
        if ($stmt->execute() && $stmt->affected_rows >= 0) {
            unset($_SESSION['reset_email'], $_SESSION['reset_otp_hash'], $_SESSION['reset_otp_expires'], $_SESSION['reset_attempts']);
            header('Location: login.php?reset=1'); exit;
        }
        $stmt->close(); $error = 'Could not update the password.';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Reset Password | BookNest</title><link rel="stylesheet" href="style.css"></head>
<body class="auth-page"><div class="login-shell"><div class="auth-card login-card">
<div class="brand-icon small">🔑</div><div class="eyebrow">RESET PASSWORD</div><h2>Create a new password</h2><p class="muted">OTP sent for <strong><?=htmlspecialchars($email)?></strong></p>
<?php if($error): ?><div class="alert error">❌ <?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="POST"><div class="field"><label>6-Digit OTP</label><input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required placeholder="Enter OTP"></div><div class="field"><label>New Password</label><input type="password" name="password" minlength="8" required placeholder="Minimum 8 characters"></div><div class="field"><label>Confirm Password</label><input type="password" name="confirm_password" minlength="8" required placeholder="Re-enter password"></div><button class="primary-btn" type="submit">Reset Password</button></form>
<div class="auth-links"><a href="forgot_password.php">Generate a new OTP</a> · <a href="login.php">Back to Login</a></div>
</div></div></body></html>
