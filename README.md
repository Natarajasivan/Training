# PHP & MySQL Training — Three-Tier Architecture

This repository helps students understand the basic concepts of PHP coding with MySQL database connection, organised using the **three-tier architecture** pattern.

---

## What You Will Learn

| Topic | Description |
|---|---|
| PHP Basics | Variables, functions, forms, and sessions |
| MySQL Connection | Connecting PHP to a MySQL database using PDO |
| Three-Tier Architecture | Separation of Presentation, Business Logic, and Data Access layers |

---

## Three-Tier Architecture Overview

```
┌─────────────────────────────────┐
│   Presentation Layer (UI)       │  presentation/
│   HTML + PHP pages shown to     │  index.php, add_student.php,
│   the user                      │  view_students.php
├─────────────────────────────────┤
│   Business Logic Layer (BLL)    │  bll/
│   Validates and processes data  │  StudentBLL.php
├─────────────────────────────────┤
│   Data Access Layer (DAL)       │  dal/
│   Talks directly to the DB      │  StudentDAL.php
└─────────────────────────────────┘
         │
         ▼
   config/database.php  ←  shared DB configuration
```

---

## Project Structure

```
Training/
├── config/
│   └── database.php          # Database connection configuration
├── dal/
│   └── StudentDAL.php        # Data Access Layer: CRUD operations
├── bll/
│   └── StudentBLL.php        # Business Logic Layer: validation & rules
├── presentation/
│   ├── index.php             # Home page
│   ├── add_student.php       # Add a new student
│   └── view_students.php     # List all students
├── sql/
│   └── setup.sql             # Database schema and sample data
└── README.md
```

---

## Prerequisites

- PHP 8.1 or higher
- MySQL 5.7 or higher (or MariaDB 10.3+)
- A web server such as Apache or Nginx (XAMPP / WAMP / LAMP stack works fine)

---

## Setup Instructions

### 1. Import the Database

Open your MySQL client (phpMyAdmin, MySQL Workbench, or the `mysql` CLI) and run:

```sql
source sql/setup.sql;
```

This creates the `training_db` database, the `students` table, and inserts a few sample records.

### 2. Configure the Database Connection

Open `config/database.php` and update the credentials to match your environment:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'training_db');
define('DB_USER', 'root');       // change if needed
define('DB_PASS', '');           // change if needed
```

### 3. Start Your Web Server

Place the project folder inside your web server's document root (e.g., `htdocs/` for XAMPP) and open a browser:

```
http://localhost/Training/presentation/index.php
```

---

## File Descriptions

### `config/database.php`
Holds the database constants and creates a reusable PDO connection.  
**Concept taught:** PDO, connection handling, separation of configuration from logic.

### `dal/StudentDAL.php`
The **Data Access Layer** — the only part of the application that executes SQL queries.  
**Concept taught:** Prepared statements, parameterised queries, preventing SQL injection.

### `bll/StudentBLL.php`
The **Business Logic Layer** — validates input and enforces business rules before passing data to the DAL.  
**Concept taught:** Input validation, separation of concerns, reusable business rules.

### `presentation/` (index, add_student, view_students)
The **Presentation Layer** — HTML/PHP pages that the user interacts with.  
**Concept taught:** HTML forms, POST/GET handling, displaying dynamic data, basic PHP templating.

### `sql/setup.sql`
Database schema and sample data.  
**Concept taught:** CREATE DATABASE, CREATE TABLE, INSERT, data types, primary keys.

---

## Learning Path (Recommended Order)

1. Read `sql/setup.sql` — understand the data model.
2. Read `config/database.php` — understand how PHP connects to MySQL using PDO.
3. Read `dal/StudentDAL.php` — understand how SQL queries are executed safely.
4. Read `bll/StudentBLL.php` — understand how data is validated before hitting the DB.
5. Read the files in `presentation/` — understand how everything is tied together for the user.
