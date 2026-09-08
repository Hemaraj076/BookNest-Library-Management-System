<?php
session_start();if(!isset($_SESSION['id'],$_SESSION['role'])||$_SESSION['role']!=='admin'){header('Location:dashboard.php');exit;}include 'db.php';if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:view_books.php');exit;}
$id=(int)($_POST['id']??0);$book=trim($_POST['book_name']??'');$author=trim($_POST['author']??'');$category=trim($_POST['category']??'');$isbn=trim($_POST['isbn']??'');$qty=(int)($_POST['quantity']??0);
if($id<1||$book===''||$author===''||$category===''||$isbn===''||$qty<1){header("Location:edit_book.php?id=$id&invalid=1");exit;}
$s=$conn->prepare('SELECT id FROM books WHERE isbn=? AND id<>? LIMIT 1');$s->bind_param('si',$isbn,$id);$s->execute();$s->store_result();if($s->num_rows){$s->close();header("Location:edit_book.php?id=$id&exists=1");exit;}$s->close();
$s=$conn->prepare("SELECT COUNT(*) c FROM borrowings WHERE book_id=? AND status='issued'");$s->bind_param('i',$id);$s->execute();$active=(int)$s->get_result()->fetch_assoc()['c'];$s->close();
if($qty<$active){header("Location:edit_book.php?id=$id&invalid=1");exit;}
$s=$conn->prepare('UPDATE books SET book_name=?,author=?,category=?,isbn=?,quantity=? WHERE id=?');$s->bind_param('ssssii',$book,$author,$category,$isbn,$qty,$id);$s->execute();$s->close();header('Location:view_books.php');exit;
