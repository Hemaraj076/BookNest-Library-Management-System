<?php
session_start();
if (!isset($_SESSION['id'], $_SESSION['role']) || !in_array($_SESSION['role'], ['student','faculty'], true)) {
    header('Location: dashboard.php'); exit;
}
include 'db.php';
$bookId = (int)($_GET['id'] ?? 0);
$uid = (int)$_SESSION['id'];
$role = $_SESSION['role'];
if ($bookId < 1) { header('Location: view_books.php'); exit; }

$maxActive = $role === 'faculty' ? 5 : 3;
$loanDays = $role === 'faculty' ? 30 : 14;

$s = $conn->prepare('SELECT id, book_name, quantity FROM books WHERE id=? LIMIT 1');
$s->bind_param('i', $bookId); $s->execute();
$book = $s->get_result()->fetch_assoc(); $s->close();
if (!$book) { header('Location: view_books.php?error=notfound'); exit; }

$s = $conn->prepare("SELECT id FROM borrowings WHERE member_id=? AND book_id=? AND status='issued' LIMIT 1");
$s->bind_param('ii', $uid, $bookId); $s->execute();
$already = $s->get_result()->num_rows > 0; $s->close();
if ($already) { header('Location: my_books.php?error=already'); exit; }

$s = $conn->prepare("SELECT COUNT(*) AS c FROM borrowings WHERE member_id=? AND status='issued'");
$s->bind_param('i', $uid); $s->execute();
$active = (int)$s->get_result()->fetch_assoc()['c']; $s->close();
if ($active >= $maxActive) { header('Location: view_books.php?error=limit'); exit; }
if ((int)$book['quantity'] < 1) { header('Location: view_books.php?error=unavailable'); exit; }

$conn->begin_transaction();
try {
    $s = $conn->prepare("UPDATE books SET quantity=quantity-1 WHERE id=? AND quantity>0");
    $s->bind_param('i', $bookId); $s->execute();
    if ($s->affected_rows !== 1) throw new Exception('Book unavailable');
    $s->close();

    $dueDate = date('Y-m-d H:i:s', strtotime("+$loanDays days"));
    $s = $conn->prepare("INSERT INTO borrowings(member_id, book_id, issued_at, due_date, status) VALUES(?,?,NOW(),?,'issued')");
    $s->bind_param('iis', $uid, $bookId, $dueDate); $s->execute(); $s->close();
    $conn->commit();
    header('Location: my_books.php?success=borrowed');
} catch (Exception $e) {
    $conn->rollback(); header('Location: view_books.php?error=failed');
}
exit;
