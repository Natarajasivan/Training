<?php
/**
 * bll/StudentBLL.php
 *
 * Business Logic Layer (BLL) — StudentBLL class
 * ----------------------------------------------
 * The BLL sits between the Presentation layer and the Data Access
 * layer.  Its responsibilities are:
 *
 *  1. VALIDATE input data (e.g. required fields, valid email, age range)
 *  2. ENFORCE business rules (e.g. "a student must be at least 16")
 *  3. DELEGATE database work to the DAL — it never runs SQL directly.
 *
 * WHY THIS MATTERS (Three-Tier Architecture):
 *  - The Presentation layer focuses only on HTML rendering.
 *  - The DAL focuses only on SQL queries.
 *  - Business rules live in ONE place; changing a rule here
 *    automatically applies everywhere the BLL is used.
 *
 * CONCEPT: Separation of Concerns
 * Each layer has a clearly defined job.  Mixing UI code, business
 * rules, and SQL in the same file makes the code hard to read,
 * test, and maintain — the three-tier pattern avoids that.
 */

require_once __DIR__ . '/../dal/StudentDAL.php';

class StudentBLL
{
    /** @var StudentDAL Used to persist / retrieve data */
    private StudentDAL $dal;

    /** @var int Minimum allowed student age */
    public const MIN_AGE = 16;

    /** @var int Maximum allowed student age */
    public const MAX_AGE = 100;

    /**
     * Constructor — create the DAL dependency.
     */
    public function __construct()
    {
        $this->dal = new StudentDAL();
    }

    // ---------------------------------------------------------------
    // READ operations
    // ---------------------------------------------------------------

    /**
     * getAllStudents()
     * Returns all students from the database.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllStudents(): array
    {
        return $this->dal->getAllStudents();
    }

    /**
     * getStudentById()
     * Returns one student, or null if the ID does not exist.
     *
     * @param  int                        $id
     * @return array<string, mixed>|null
     */
    public function getStudentById(int $id): ?array
    {
        $student = $this->dal->getStudentById($id);
        return $student !== false ? $student : null;
    }

    // ---------------------------------------------------------------
    // CREATE operation
    // ---------------------------------------------------------------

    /**
     * addStudent()
     * Validates the supplied data and, if valid, delegates the INSERT
     * to the DAL.  Returns the new student_id on success.
     *
     * @param  string $name
     * @param  string $email
     * @param  mixed  $age    (string from form, cast to int after validation)
     * @param  string $course
     * @return array{success: bool, errors: string[], student_id: int|null}
     */
    public function addStudent(string $name, string $email, mixed $age, string $course): array
    {
        $errors = $this->validateStudentInput($name, $email, $age, $course);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors, 'student_id' => null];
        }

        $newId = $this->dal->addStudent(
            trim($name),
            strtolower(trim($email)),  // business rule: store emails in lower case
            (int) $age,
            trim($course)
        );

        return ['success' => true, 'errors' => [], 'student_id' => $newId];
    }

    // ---------------------------------------------------------------
    // DELETE operation
    // ---------------------------------------------------------------

    /**
     * deleteStudent()
     * Deletes a student after confirming the ID is a positive integer.
     *
     * @param  mixed $id
     * @return array{success: bool, message: string}
     */
    public function deleteStudent(mixed $id): array
    {
        if (!is_numeric($id) || (int) $id < 1) {
            return ['success' => false, 'message' => 'Invalid student ID.'];
        }

        $deleted = $this->dal->deleteStudent((int) $id);

        if ($deleted) {
            return ['success' => true, 'message' => 'Student deleted successfully.'];
        }

        return ['success' => false, 'message' => 'Student not found.'];
    }

    // ---------------------------------------------------------------
    // Private helper — input validation
    // ---------------------------------------------------------------

    /**
     * validateStudentInput()
     * Applies business rules to the supplied student data.
     * Returns an array of human-readable error messages (empty = valid).
     *
     * @param  string $name
     * @param  string $email
     * @param  mixed  $age
     * @param  string $course
     * @return string[]
     */
    private function validateStudentInput(
        string $name,
        string $email,
        mixed $age,
        string $course
    ): array {
        $errors = [];

        // Rule: name is required and must not exceed 100 characters
        if (trim($name) === '') {
            $errors[] = 'Name is required.';
        } elseif (strlen(trim($name)) > 100) {
            $errors[] = 'Name must not exceed 100 characters.';
        }

        // Rule: email must be present and in a valid format
        if (trim($email) === '') {
            $errors[] = 'Email address is required.';
        } elseif (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        // Rule: age must be a number within the allowed range
        if (!is_numeric($age) || (int) $age < self::MIN_AGE || (int) $age > self::MAX_AGE) {
            $errors[] = sprintf(
                'Age must be a number between %d and %d.',
                self::MIN_AGE,
                self::MAX_AGE
            );
        }

        // Rule: course name is required
        if (trim($course) === '') {
            $errors[] = 'Course name is required.';
        }

        return $errors;
    }
}
