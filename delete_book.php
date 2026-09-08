<?php
session_start();if(!isset($_SESSION['id'],$_SESSION['role'])||$_SESSION['role']!=='admin'){header('Location:dashboard.php');exit;}include 'db.php';
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);if(!$id){header('Location:view_books.php');exit;}
$s=$conn->prepare('SELECT COUNT(*) c FROM borrowings WHERE book_id=?');$s->bind_param('i',$id);$s->execute();$count=(int)$s->get_result()->fetch_assoc()['c'];$s->close();
if($count>0){header('Location:view_books.php?error=has_history');exit;}
$s=$conn->prepare('DELETE FROM books WHERE id=?');$s->bind_param('i',$id);$s->execute();$s->close();header('Location:view_books.php');exit;
