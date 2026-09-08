📚 BookNest — Library Management System

BookNest is a web-based Library Management System designed to simplify and digitize library operations such as book management, member management, borrowing, returning, and role-based access control.

The system provides separate access and permissions for Students, Faculty, and Administrators.

🌐 Live Demo

BookNest: https://booknest.infinityfree.io/

✨ Features
🔐 Authentication
User Registration
Secure Login
Logout
Forgot Password
OTP-based Password Reset
Password Hashing
Session-based Authentication
👨‍🎓 Student
View available books
Search books
Borrow books
Return borrowed books
View personal borrowing history
Track due dates
View overdue books
Maximum 3 active books
14-day borrowing period
👨‍🏫 Faculty
View available books
Search books
Borrow books
Return borrowed books
View personal borrowing history
Track due dates
View overdue books
Maximum 5 active books
30-day borrowing period
🛡️ Administrator
View dashboard statistics
Add books
Edit books
Delete books
View and search books
Manage borrowings
Track issued and overdue books
Manage library members
View member details
Full library management access
🔒 Security
Passwords are securely stored using password hashing.
Session-based authentication protects user accounts.
Role-based access control restricts features according to user roles.
Students and Faculty cannot access administrative functions.
Database credentials are kept separate from the public GitHub repository.
Sensitive configuration files are excluded using .gitignore.
🔄 System Workflow
User Registration
       ↓
     Login
       ↓
Role Identification
       ↓
 ┌───────────────┬───────────────┬───────────────┐
 ↓               ↓               ↓
Student         Faculty         Admin
 ↓               ↓               ↓
View Books      View Books      Manage Books
Borrow          Borrow          Manage Members
Return          Return          Manage Borrowings
My Books        My Books        Dashboard
🛠️ Technologies Used
Technology	Purpose
HTML5	Page Structure
CSS3	Styling and Responsive UI
JavaScript	Client-side Interactions
PHP	Backend Development
MySQL	Database Management
XAMPP	Local Development
InfinityFree	Web Hosting
Git & GitHub	Version Control
🗄️ Database

The project uses MySQL as the database system.

Main Tables
members — Stores user and role information
books — Stores book details and available quantities
borrowings — Stores book issue, due date, return, and borrowing status
Borrowing Information

The borrowing system tracks:

Member
Book
Issue Date
Due Date
Return Date
Borrowing Status
👥 Role-Based Access
Feature	Student	Faculty	Admin
Login	✅	✅	✅
View Books	✅	✅	✅
Search Books	✅	✅	✅
Borrow Books	✅	✅	❌
Return Own Books	✅	✅	❌
View Own Borrowings	✅	✅	❌
Add Books	❌	❌	✅
Edit Books	❌	❌	✅
Delete Books	❌	❌	✅
Manage Borrowings	❌	❌	✅
Manage Members	❌	❌	✅
Dashboard Statistics	Limited	Limited	✅
📋 Borrowing Policies
Student
Maximum active books: 3
Borrowing period: 14 days
Faculty
Maximum active books: 5
Borrowing period: 30 days

The system prevents users from borrowing the same book again while they already have an active borrowing record for it.

📸 Screenshots
🔐 Login Page

📝 Registration Page

👨‍🎓 Student Dashboard

👨‍🏫 Faculty Dashboard

🛡️ Admin Dashboard

📚 Books Management

📋 Borrowing Management

📁 Project Structure
LibrarySystem/
│
├── add_book.php
├── authenticate.php
├── borrow_book.php
├── dashboard.php
├── delete_book.php
├── edit_book.php
├── forgot_password.php
├── index.php
├── login.php
├── logout.php
├── manage_borrowings.php
├── manage_members.php
├── my_books.php
├── register.php
├── reset_password.php
├── return_book.php
├── save_book.php
├── script.js
├── style.css
├── update_book.php
├── view_books.php
│
├── screenshots/
│   ├── login.png
│   ├── register.png
│   ├── student-dashboard.png
│   ├── faculty-dashboard.png
│   ├── admin-dashboard.png
│   ├── books.png
│   └── borrowings.png
│
└── README.md
⚙️ Local Installation
1. Install XAMPP

Install XAMPP and start:

Apache
MySQL
2. Place the Project

Copy the project folder into:

C:\xampp\htdocs\
3. Create the Database

Open:

http://localhost/phpmyadmin/

Create a database named:

library_db

Import the required database tables into the database.

4. Configure Database Connection

For local XAMPP development, configure db.php with your local MySQL credentials.

Typical XAMPP configuration:

Host: localhost
Username: root
Password:
Database: library_db
5. Run the Project

Open:

http://localhost/LibrarySystem/
🌐 Deployment

The project is deployed using InfinityFree.

The live application is available at:

https://booknest.infinityfree.io/

The database is hosted using the MySQL database service provided by the hosting platform.

Sensitive database configuration is not included in the public GitHub repository.

🎯 Project Objectives

The main objectives of BookNest are:

Digitize traditional library management.
Reduce manual book tracking.
Simplify borrowing and returning processes.
Provide role-based access control.
Track book availability in real time.
Maintain member and borrowing records.
Provide a simple and professional user interface.
Deploy the application as a live web application.
🚀 Future Improvements

Possible future enhancements include:

Email notifications for due dates
Automatic overdue reminders
Book cover image uploads
Advanced search and filtering
Fine calculation
PDF reports
Admin analytics and charts
Online book reservations
Improved mobile responsiveness
Cloud database integration
🎓 Academic Project

This project was developed as a practical web development project to demonstrate skills in:

Frontend development
Backend development
Database management
Authentication
Role-based authorization
CRUD operations
Web hosting
Git and GitHub
👨‍💻 Developer

Hemaraj Vydani

GitHub:
https://github.com/Hemaraj076

Project Repository:
https://github.com/Hemaraj076/BookNest-Library-Management-System

📄 License

This project is developed for educational and academic purposes.