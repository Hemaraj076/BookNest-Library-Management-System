<?php
session_start();
include 'db.php';
if (isset($_SESSION['id'])) { header('Location: dashboard.php'); exit; }
$message = '';
$demoOtp = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        $stmt = $conn->prepare('SELECT id FROM members WHERE email=? LIMIT 1');
        $stmt->bind_param('s', $email); $stmt->execute();
        $exists = $stmt->get_result()->fetch_assoc(); $stmt->close();
        if (!$exists) {
            $message = 'No account was found with that email address.';
        } else {
            $otp = (string)random_int(100000, 999999);
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_otp_hash'] = password_hash($otp, PASSWORD_DEFAULT);
            $_SESSION['reset_otp_expires'] = time() + 600;
            $_SESSION['reset_attempts'] = 0;
            // Local XAMPP demo: display the generated OTP. Replace with SMTP mail delivery for production.
            $demoOtp = $otp;
            $message = 'OTP generated successfully. It is valid for 10 minutes.';
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Forgot Password | BookNest</title><link rel="stylesheet" href="style.css"></head>
<body class="auth-page"><div class="login-shell"><div class="auth-card login-card">
<div class="brand-icon small">🔐</div><div class="eyebrow">ACCOUNT RECOVERY</div><h2>Forgot Password?</h2><p class="muted">Enter your registered email to generate a 6-digit OTP.</p>
<?php if($message): ?><div class="alert <?= $demoOtp ? 'success':'error' ?>"> <?=htmlspecialchars($message)?> </div><?php endif; ?>
<?php if($demoOtp): ?><div class="otp-demo"><span>Demo OTP</span><strong><?=htmlspecialchars($demoOtp)?></strong><small>For local XAMPP testing. In a production deployment, send this OTP by email.</small></div><a class="primary-btn link-btn" href="reset_password.php">Continue to Reset Password</a><?php endif; ?>
<?php if(!$demoOtp): ?><form method="POST"><div class="field"><label>Email Address</label><input type="email" name="email" required autocomplete="email" placeholder="Enter your registered email"></div><button class="primary-btn" type="submit">Generate OTP</button></form><?php endif; ?>
<div class="auth-links"><a href="login.php">← Back to Login</a></div>
</div></div></body></html>
