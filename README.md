# 📚 BookNest – Library Management System

BookNest is a web-based Library Management System designed to simplify and automate library operations such as book management, member management, borrowing, returning, and user authentication.

The system provides different access levels for **Students, Faculty, and Administrators**, making library management more organized, secure, and efficient.

## 🌐 Live Demo

🔗 https://booknest.infinityfree.io/

## ✨ Features

### 👨‍🎓 Student
- Secure registration and login
- View and search available books
- Borrow books
- Return borrowed books
- View personal borrowing history
- Maximum 3 active books
- 14-day borrowing period

### 👨‍🏫 Faculty
- Secure registration and login
- View and search available books
- Borrow books
- Return borrowed books
- View personal borrowing history
- Maximum 5 active books
- 30-day borrowing period

### 🛡️ Administrator
- Secure admin login
- View library statistics
- Add new books
- Edit book information
- Delete books
- Manage members
- Manage borrowing records
- Monitor overdue books
- View available book copies
- Full library management access

## 🔐 Authentication & Security

- Passwords are securely hashed using PHP password hashing
- Session-based authentication
- Role-based access control
- Duplicate email and roll-number validation
- Protected database credentials
- OTP-based password reset functionality
- Separate permissions for Students, Faculty, and Administrators

## 🔄 Library Workflow

```text
User Registration
       ↓
     Login
       ↓
Role Identification
       ↓
 ┌─────┼─────┐
 ↓     ↓     ↓
Student Faculty Admin
 ↓     ↓     ↓
Borrow/Return   Manage Library
       ↓
 Borrowing Records
       ↓
 Return Book