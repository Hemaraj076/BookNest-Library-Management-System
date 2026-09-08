<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: dashboard.php'); exit;
}
$error = $_GET['error'] ?? '';
$messages = [
 'email' => 'Email address is already registered.',
 'roll' => 'ID / Roll Number is already registered.',
 'mobile' => 'Mobile number is already registered.',
 'db' => 'Registration failed. Please try again.'
];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>BookNest | Registration</title><link rel="stylesheet" href="style.css"></head>
<body class="auth-page">
<div class="auth-shell">
  <div class="brand-panel"><div class="brand-icon">📚</div><h1>BookNest</h1><p>Smart Library Management System</p><div class="feature-list"><span>✓ Role-based access</span><span>✓ Easy book management</span><span>✓ Secure member login</span></div></div>
  <div class="auth-card">
    <div class="eyebrow">MEMBERSHIP PORTAL</div><h2>Create your account</h2><p class="muted">Choose your role and register for BookNest.</p>
    <?php if ($error && isset($messages[$error])): ?><div class="alert error">❌ <?= htmlspecialchars($messages[$error]) ?></div><?php endif; ?>
    <form action="register.php" method="POST" onsubmit="return validateForm()">
      <div class="form-grid">
        <div class="field full"><label>Account Type</label><select name="role" id="role" required><option value="">Select role</option><option value="student">🎓 Student</option><option value="faculty">👨‍🏫 Faculty</option><option value="admin">🛡️ Admin</option></select></div>
        <div class="field"><label>Full Name</label><input id="name" name="name" required placeholder="Enter full name"></div>
        <div class="field"><label>ID / Roll Number</label><input id="roll" name="roll" required placeholder="Enter ID or roll number"></div>
        <div class="field"><label>Department</label><select id="department" name="department" required><option value="">Select department</option><option>CSE</option><option>CSBS</option><option>ECE</option><option>EEE</option><option>MECH</option><option>CIVIL</option><option>Administration</option></select></div>
        <div class="field"><label>Mobile Number</label><input id="mobile" name="mobile" inputmode="numeric" required placeholder="10-digit mobile"></div>
        <div class="field"><label>Email Address</label><input id="email" name="email" type="email" required placeholder="name@example.com"></div>
        <div class="field"><label>Password</label><input id="password" name="password" type="password" minlength="8" required placeholder="Minimum 8 characters"></div>
        <div class="field"><label>Confirm Password</label><input id="confirmPassword" type="password" minlength="8" required placeholder="Re-enter password"></div>
      </div>
      <button class="primary-btn" type="submit">Create Account</button>
    </form>
    <p class="switch-link">Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>
<script src="script.js"></script></body></html>
