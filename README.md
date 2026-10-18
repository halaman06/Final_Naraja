# Final_Naraja

Final project for Web Application Development. A simple web app for tracking items in a small store.

- Live website: https://naraja-kim.infinityfree.io/
- GitHub: https://github.com/username/inventory-manager (change this)

## Admin login (for grading)

- Email: admin@example.com
- Password: password

You can also register a new account to test the normal user role.

## Features

- Register and login (passwords hashed with `password_hash()`)
- Two roles: **admin** and **user**
  - user: can only see and manage their own items
  - admin: can manage all items and delete users
- Add, view, edit and delete items (CRUD)
- Live search using JavaScript `fetch()`
- Client-side validation (JavaScript) and server-side validation (PHP)
- Prepared statements (SQL injection) and `htmlspecialchars()` (XSS)
- Responsive layout using Bootstrap 5

## Technologies

HTML5, CSS3, Bootstrap 5, JavaScript, PHP, MySQL

## How to run

1. Create a database (example: `inventory_db`) in phpMyAdmin
2. Import `database/schema.sql`
3. Open `config.php` and put your database host, username, password and database name
4. Upload all the files to your hosting (`htdocs` folder in InfinityFree) or put them in `htdocs` of XAMPP
5. Open the site in the browser

## Files

- `config.php` - database connection and session
- `login.php`, `register.php`, `logout.php` - authentication
- `dashboard.php`, `search.php` - list and search items
- `add.php`, `edit.php`, `delete.php` - item CRUD
- `users.php` - admin page for users
- `script.js` - validation and live search
- `database/schema.sql` - database tables
