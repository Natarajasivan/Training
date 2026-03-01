-- =============================================================
-- PHP & MySQL Training -- Database Setup
-- =============================================================
-- Run this file once to create the database, table, and sample
-- data used by the three-tier architecture demo.
-- =============================================================

-- Step 1: Create and select the database
CREATE DATABASE IF NOT EXISTS training_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE training_db;

-- Step 2: Create the students table
-- Primary key:   student_id  (auto-incremented integer)
-- Data columns:  name, email, age, course, enrolled_on
CREATE TABLE IF NOT EXISTS students (
    student_id   INT          NOT NULL AUTO_INCREMENT,
    name         VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL UNIQUE,
    age          TINYINT      NOT NULL CHECK (age >= 1 AND age <= 120),
    course       VARCHAR(100) NOT NULL,
    enrolled_on  DATE         NOT NULL DEFAULT (CURRENT_DATE),
    PRIMARY KEY (student_id)
) ENGINE=InnoDB;

-- Step 3: Insert sample data
INSERT INTO students (name, email, age, course, enrolled_on) VALUES
    ('Alice Johnson',  'alice@example.com',  20, 'PHP & MySQL',     '2025-01-15'),
    ('Bob Smith',      'bob@example.com',    22, 'Web Development', '2025-01-20'),
    ('Carol Williams', 'carol@example.com',  19, 'PHP & MySQL',     '2025-02-01'),
    ('David Brown',    'david@example.com',  24, 'Database Design', '2025-02-10');
