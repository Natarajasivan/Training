<?php
/**
 * dal/StudentDAL.php
 *
 * Data Access Layer (DAL) — StudentDAL class
 * ------------------------------------------
 * The DAL is the ONLY layer that communicates directly with the
 * database.  All SQL queries live here.  The BLL and Presentation
 * layers never write SQL — they call methods on this class instead.
 *
 * WHY THIS MATTERS (Three-Tier Architecture):
 *  - If you change the database engine (e.g. MySQL → PostgreSQL),
 *    only this file needs to change.
 *  - Business rules in the BLL remain untouched.
 *  - UI code in the Presentation layer remains untouched.
 *
 * CONCEPT: Prepared Statements
 * Prepared statements separate SQL code from user-supplied data.
 * The database compiles the query template once, then binds the
 * parameter values separately — so user input can NEVER alter the
 * SQL structure.  This prevents SQL injection attacks.
 *
 * Example (vulnerable — NEVER do this):
 *   $pdo->query("SELECT * FROM students WHERE name = '$name'");
 *
 * Example (safe — always do this):
 *   $stmt = $pdo->prepare("SELECT * FROM students WHERE name = :name");
 *   $stmt->execute([':name' => $name]);
 */

require_once __DIR__ . '/../config/database.php';

class StudentDAL
{
    /** @var PDO Shared database connection */
    private PDO $pdo;

    /**
     * Constructor — obtain a database connection on instantiation.
     */
    public function __construct()
    {
        $this->pdo = getDBConnection();
    }

    // ---------------------------------------------------------------
    // READ operations
    // ---------------------------------------------------------------

    /**
     * getAllStudents()
     * Fetches every row from the students table, ordered by name.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllStudents(): array
    {
        $stmt = $this->pdo->query(
            'SELECT student_id, name, email, age, course, enrolled_on
               FROM students
           ORDER BY name ASC'
        );
        // fetchAll() returns all rows as an array of associative arrays
        return $stmt->fetchAll();
    }

    /**
     * getStudentById()
     * Fetches a single student by primary key.
     *
     * @param  int                        $id
     * @return array<string, mixed>|false
     */
    public function getStudentById(int $id): array|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT student_id, name, email, age, course, enrolled_on
               FROM students
              WHERE student_id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(); // returns one row or false
    }

    // ---------------------------------------------------------------
    // CREATE operation
    // ---------------------------------------------------------------

    /**
     * addStudent()
     * Inserts a new student record and returns the new auto-increment ID.
     *
     * @param  string $name
     * @param  string $email
     * @param  int    $age
     * @param  string $course
     * @return int    The new student_id
     */
    public function addStudent(string $name, string $email, int $age, string $course): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO students (name, email, age, course, enrolled_on)
             VALUES (:name, :email, :age, :course, CURRENT_DATE)'
        );
        $stmt->execute([
            ':name'   => $name,
            ':email'  => $email,
            ':age'    => $age,
            ':course' => $course,
        ]);
        // lastInsertId() returns the auto-generated ID of the new row
        return (int) $this->pdo->lastInsertId();
    }

    // ---------------------------------------------------------------
    // DELETE operation
    // ---------------------------------------------------------------

    /**
     * deleteStudent()
     * Deletes a student by primary key.
     * Returns true if a row was deleted, false if the ID did not exist.
     *
     * @param  int  $id
     * @return bool
     */
    public function deleteStudent(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM students WHERE student_id = :id'
        );
        $stmt->execute([':id' => $id]);
        // rowCount() tells us how many rows were affected
        return $stmt->rowCount() > 0;
    }
}
