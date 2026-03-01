<?php
/**
 * config/database.php
 *
 * Database Configuration
 * ----------------------
 * This file centralises all database connection settings.
 * Having configuration in one place means you only need to
 * update credentials here — not in every file that needs a DB.
 *
 * CONCEPT: PDO (PHP Data Objects)
 * PDO is a database-access abstraction layer. It provides a
 * consistent API for multiple database drivers (MySQL, SQLite,
 * PostgreSQL, ...) and supports prepared statements that protect
 * against SQL injection attacks.
 */

// ---------------------------------------------------------------
// 1. Connection settings — update these to match your environment
// ---------------------------------------------------------------
define('DB_HOST', 'localhost');   // MySQL server hostname
define('DB_NAME', 'training_db'); // Database name (created by sql/setup.sql)
define('DB_USER', 'root');        // MySQL username
define('DB_PASS', '');            // MySQL password (empty for local XAMPP/WAMP)
define('DB_CHARSET', 'utf8mb4'); // Character set — utf8mb4 supports all Unicode

/**
 * getDBConnection()
 *
 * Creates and returns a PDO database connection.
 * Throws a PDOException if the connection fails (caught by callers).
 *
 * PDO options used:
 *  - ERRMODE_EXCEPTION  : throw exceptions on DB errors (easy to catch)
 *  - DEFAULT_FETCH_MODE : return rows as associative arrays by default
 *  - EMULATE_PREPARES   : disabled so the DB driver handles real prepared statements
 *
 * @return PDO
 * @throws PDOException
 */
function getDBConnection(): PDO
{
    // Build the DSN (Data Source Name) string
    // Format: mysql:host=<host>;dbname=<db>;charset=<charset>
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // new PDO(...) opens the connection. If it fails, PDOException is thrown.
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}
