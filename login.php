<?php
session_start();
if (isset($_SESSION['id'])) { header('Location: dashboard.php'); exit; }
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>BookNest | Login</title><link rel="stylesheet" href="style.css"></head>
<body class="auth-page">
<div class="login-shell">
  <div class="auth-card login-card">
    <div class="brand-icon small">📚</div>
    <div class="eyebrow">WELCOME BACK</div>
    <h2>Sign in to BookNest</h2>
    <p class="muted">Enter your registered email and password. Your account role is detected automatically.</p>
    <?php if(isset($_GET['registered'])): ?><div class="alert success">✅ Registration successful. Please login.</div><?php endif; ?><?php if(isset($_GET['reset'])): ?><div class="alert success">✅ Password reset successfully. Please login with your new password.</div><?php endif; ?>
    <?php if($error==='1'): ?><div class="alert error">❌ Invalid email or password.</div><?php endif; ?>
    <?php if(isset($_GET['reset'])): ?><div class="alert success">✅ Password reset successfully. You can now login.</div><?php endif; ?><?php if($error==='reset'): ?><div class="alert error">❌ Password reset failed or the OTP expired.</div><?php endif; ?>
    <form action="authenticate.php" method="POST">
      <div class="field"><label>Email Address</label><input type="email" name="email" required autocomplete="email" placeholder="Enter your email"></div>
      <div class="field"><label>Password</label><input type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"></div>
      <button class="primary-btn" type="submit">Login to BookNest</button>
    </form>
    <div class="auth-links"><a href="forgot_password.php">Forgot Password?</a></div>
    <p class="switch-link">New to BookNest? <a href="index.php">Create an account</a></p>
  </div>
</div>
</body></html>
