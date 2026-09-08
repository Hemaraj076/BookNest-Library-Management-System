<?php
session_start();
if (!isset($_SESSION['id'], $_SESSION['role']) || !in_array($_SESSION['role'], ['student','faculty','admin'], true)) { header('Location: login.php'); exit; }
include 'db.php';
$role=$_SESSION['role']; $uid=(int)$_SESSION['id'];
$totalBooks=(int)$conn->query("SELECT COUNT(*) c FROM books")->fetch_assoc()['c'];
$available=(int)$conn->query("SELECT COALESCE(SUM(quantity),0) c FROM books")->fetch_assoc()['c'];
$totalMembers=(int)$conn->query("SELECT COUNT(*) c FROM members")->fetch_assoc()['c'];
$myActive=$issued=$overdue=0;
if($role==='admin'){
  $issued=(int)$conn->query("SELECT COUNT(*) c FROM borrowings WHERE status='issued'")->fetch_assoc()['c'];
  $overdue=(int)$conn->query("SELECT COUNT(*) c FROM borrowings WHERE status='issued' AND due_date IS NOT NULL AND due_date < NOW()")->fetch_assoc()['c'];
}else{
  $s=$conn->prepare("SELECT COUNT(*) c FROM borrowings WHERE member_id=? AND status='issued'");$s->bind_param('i',$uid);$s->execute();$myActive=(int)$s->get_result()->fetch_assoc()['c'];$s->close();
  $s=$conn->prepare("SELECT COUNT(*) c FROM borrowings WHERE member_id=? AND status='issued' AND due_date IS NOT NULL AND due_date < NOW()");$s->bind_param('i',$uid);$s->execute();$overdue=(int)$s->get_result()->fetch_assoc()['c'];$s->close();
}
$roleTitle=['student'=>'Student Dashboard','faculty'=>'Faculty Dashboard','admin'=>'Admin Dashboard'][$role];
$roleIcon=['student'=>'🎓','faculty'=>'👨‍🏫','admin'=>'🛡️'][$role];
$loanDays=$role==='faculty'?30:14; $maxActive=$role==='faculty'?5:3;
$description=$role==='admin'?'Control the complete library system from one place.':($role==='faculty'?'Borrow up to 5 books with a 30-day loan period.':'Borrow up to 3 books with a 14-day loan period.');
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title><?=htmlspecialchars($roleTitle)?> | BookNest</title><link rel="stylesheet" href="style.css"></head>
<body class="app-body"><header class="topbar"><a class="top-brand" href="dashboard.php">📚 BookNest <small>Library</small></a><div class="user-chip"><?=$roleIcon?> <?=htmlspecialchars($_SESSION['name'])?><span class="role-pill"><?=ucfirst($role)?></span></div></header>
<div class="app-layout"><aside class="sidebar"><div class="side-role"><span class="big-icon"><?=$roleIcon?></span><div><strong><?=ucfirst($role)?></strong><small><?=htmlspecialchars($_SESSION['department'])?></small></div></div><nav>
<a class="active" href="dashboard.php">🏠 <span>Dashboard</span></a><a href="view_books.php">📖 <span>View Books</span></a>
<?php if($role!=='admin'): ?><a href="my_books.php">📚 <span>My Borrowed Books</span></a><?php endif; ?>
<?php if($role==='admin'): ?><a href="add_book.php">➕ <span>Add Book</span></a><a href="manage_borrowings.php">🔄 <span>Manage Borrowings</span></a><a href="manage_members.php">👥 <span>Manage Members</span></a><?php endif; ?>
<a href="logout.php">🚪 <span>Logout</span></a></nav><div class="sidebar-footer">BookNest v2.2<br><small>Role-Based Library</small></div></aside>
<main class="main-content"><div class="welcome"><div><div class="eyebrow"><?=strtoupper($roleTitle)?></div><h1>Welcome, <?=htmlspecialchars($_SESSION['name'])?> 👋</h1><p><?=$description?></p></div><div class="welcome-badge"><?=$roleIcon?></div></div>
<div class="stats"><a class="stat-card stat-link" href="view_books.php"><span class="stat-icon">📚</span><div><small>Total Titles</small><strong><?=$totalBooks?></strong><em>View books →</em></div></a><a class="stat-card stat-link" href="view_books.php"><span class="stat-icon">📦</span><div><small>Available Copies</small><strong><?=$available?></strong><em>Browse collection →</em></div></a>
<?php if($role==='admin'): ?><a class="stat-card stat-link" href="manage_members.php"><span class="stat-icon">👥</span><div><small>Total Members</small><strong><?=$totalMembers?></strong><em>Manage members →</em></div></a><a class="stat-card stat-link" href="manage_borrowings.php"><span class="stat-icon">🔄</span><div><small>Currently Issued</small><strong><?=$issued?></strong><em>Manage borrowings →</em></div></a><a class="stat-card stat-link" href="manage_borrowings.php?filter=overdue"><span class="stat-icon">⚠️</span><div><small>Overdue Loans</small><strong><?=$overdue?></strong><em>View overdue →</em></div></a>
<?php else: ?><a class="stat-card stat-link" href="my_books.php"><span class="stat-icon">📌</span><div><small>My Active Books</small><strong><?=$myActive?></strong><em>View my books →</em></div></a><a class="stat-card stat-link" href="my_books.php"><span class="stat-icon">⚠️</span><div><small>My Overdue Books</small><strong><?=$overdue?></strong><em>View overdue →</em></div></a><?php endif; ?></div>
<div class="section-title"><div><h2>Quick Actions</h2><p>Click any card below to open that feature.</p></div></div><div class="action-grid">
<a class="action-card clickable" href="view_books.php"><span>📖</span><div><strong>Browse Books</strong><small>Search and view the library collection.</small></div><b>→</b></a>
<?php if($role!=='admin'): ?><a class="action-card clickable" href="my_books.php"><span>📚</span><div><strong>My Borrowed Books</strong><small>See active loans, due dates and returns.</small></div><b>→</b></a><div class="info-card"><span><?=$roleIcon?></span><div><strong><?=ucfirst($role)?> Loan Policy</strong><small><?=$loanDays?>-day loan period · Maximum <?=$maxActive?> active books.</small></div></div>
<?php else: ?><a class="action-card clickable" href="add_book.php"><span>➕</span><div><strong>Add New Book</strong><small>Add a title and quantity to the collection.</small></div><b>→</b></a><a class="action-card clickable" href="manage_borrowings.php"><span>🔄</span><div><strong>Manage Borrowings</strong><small>Monitor issued books, due dates and returns.</small></div><b>→</b></a><a class="action-card clickable" href="manage_members.php"><span>👥</span><div><strong>Manage Members</strong><small>View students, faculty and admin accounts.</small></div><b>→</b></a><?php endif; ?></div>
<div class="role-note"><?php if($role==='student'): ?><strong>🎓 Student access</strong><span>Browse, borrow and return your own books. Book management is restricted to Admin.</span><?php elseif($role==='faculty'): ?><strong>👨‍🏫 Faculty access</strong><span>Browse, borrow and return your own books with a 5-book / 30-day policy. Book management is restricted to Admin.</span><?php else: ?><strong>🛡️ Admin access</strong><span>Full control over books, members and borrowing records.</span><?php endif; ?></div></main></div></body></html>
