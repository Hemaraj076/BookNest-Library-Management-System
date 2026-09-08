BOOKNEST LIBRARY MANAGEMENT SYSTEM
=================================

Tech Stack
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Local Server: XAMPP
- Hosting: InfinityFree

ROLES
- Student: browse/search, borrow up to 3 books, 14-day loan period, return own books
- Faculty: browse/search, borrow up to 5 books, 30-day loan period, return own books
- Admin: full book management and borrowing monitoring

SETUP
1. Copy LibrarySystem to C:\xampp\htdocs\
2. Start Apache and MySQL in XAMPP.
3. Create/use database library_db.
4. Ensure books and members tables exist.
5. Run database_setup.sql once from phpMyAdmin while library_db is selected.
6. Open http://localhost/LibrarySystem/

IMPORTANT
- db.php in this package is for local XAMPP only. Do not upload local database credentials to GitHub.
- For InfinityFree, use the hosting database credentials in a separate hosted configuration.
- The database_setup.sql is designed to migrate the earlier borrowing column names (issue_date/return_date) to issued_at/returned_at and add due_date.
