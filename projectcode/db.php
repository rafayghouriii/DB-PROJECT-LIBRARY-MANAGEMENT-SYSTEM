<?php

function getDB() {
    static $conn = null;
    if ($conn === null) {
        $dbFile = __DIR__ . '/database.sqlite';
        $isNew = !file_exists($dbFile);
        
        try {
            $conn = new PDO("sqlite:" . $dbFile);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Enable foreign keys
            $conn->exec("PRAGMA foreign_keys = ON;");
            
            if ($isNew) {
                initDB($conn);
            }
        } catch (PDOException $e) {
            die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
        }
    }
    return $conn;
}

function initDB($conn) {
    $schema = <<<SQL
    CREATE TABLE IF NOT EXISTS members (
        member_id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        phone TEXT,
        address TEXT,
        membership_date DATE DEFAULT CURRENT_DATE,
        status TEXT DEFAULT 'active' CHECK (status IN ('active', 'inactive'))
    );

    CREATE TABLE IF NOT EXISTS categories (
        category_id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_name TEXT UNIQUE NOT NULL,
        description TEXT
    );

    CREATE TABLE IF NOT EXISTS books (
        book_id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        author TEXT NOT NULL,
        isbn TEXT UNIQUE,
        category_id INTEGER REFERENCES categories(category_id) ON DELETE SET NULL,
        total_copies INTEGER DEFAULT 1,
        available_copies INTEGER DEFAULT 1,
        published_year INTEGER,
        publisher TEXT
    );

    CREATE TABLE IF NOT EXISTS issued_books (
        issue_id INTEGER PRIMARY KEY AUTOINCREMENT,
        book_id INTEGER REFERENCES books(book_id) ON DELETE CASCADE,
        member_id INTEGER REFERENCES members(member_id) ON DELETE CASCADE,
        issue_date DATE DEFAULT CURRENT_DATE,
        due_date DATE DEFAULT (date('now', '+14 days')),
        return_date DATE,
        status TEXT DEFAULT 'issued' CHECK (status IN ('issued', 'returned'))
    );

    CREATE TABLE IF NOT EXISTS fines (
        fine_id INTEGER PRIMARY KEY AUTOINCREMENT,
        issue_id INTEGER REFERENCES issued_books(issue_id) ON DELETE CASCADE,
        member_id INTEGER REFERENCES members(member_id) ON DELETE CASCADE,
        fine_amount DECIMAL(10,2) DEFAULT 0.00,
        paid BOOLEAN DEFAULT 0,
        fine_date DATE DEFAULT CURRENT_DATE
    );

    INSERT OR IGNORE INTO categories (category_name, description) VALUES
    ('Science Fiction', 'Futuristic and speculative fiction'),
    ('History', 'Historical events and biographies'),
    ('Programming', 'Software and coding books'),
    ('Mathematics', 'Pure and applied mathematics'),
    ('Literature', 'Classic and modern literature'),
    ('Science', 'Natural and physical sciences');

    INSERT OR IGNORE INTO books (title, author, isbn, category_id, total_copies, available_copies, published_year, publisher) VALUES
    ('Dune', 'Frank Herbert', '978-0441013593', 1, 3, 3, 1965, 'Chilton Books'),
    ('1984', 'George Orwell', '978-0451524935', 5, 2, 2, 1949, 'Secker & Warburg'),
    ('Sapiens', 'Yuval Noah Harari', '978-0062316097', 2, 4, 4, 2011, 'Harvill Secker'),
    ('Clean Code', 'Robert C. Martin', '978-0132350884', 3, 3, 3, 2008, 'Prentice Hall'),
    ('A Brief History of Time', 'Stephen Hawking', '978-0553380163', 6, 2, 2, 1988, 'Bantam Books'),
    ('The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 5, 3, 3, 1925, 'Scribner'),
    ('Introduction to Algorithms', 'Thomas H. Cormen', '978-0262033848', 3, 2, 2, 2009, 'MIT Press'),
    ('Cosmos', 'Carl Sagan', '978-0345539434', 6, 2, 2, 1980, 'Random House'),
    ('The Selfish Gene', 'Richard Dawkins', '978-0198788607', 6, 2, 2, 1976, 'Oxford University Press'),
    ('Calculus', 'James Stewart', '978-1285740621', 4, 3, 3, 2015, 'Cengage Learning'),
    ('To Kill a Mockingbird', 'Harper Lee', '978-0061935466', 5, 2, 2, 1960, 'J. B. Lippincott'),
    ('The Pragmatic Programmer', 'Andrew Hunt', '978-0135957059', 3, 2, 2, 1999, 'Addison-Wesley');

    INSERT OR IGNORE INTO members (name, email, phone, address, membership_date) VALUES
    ('Ali Hassan', 'ali@example.com', '0300-1234567', 'House 12, Block A, Karachi', '2024-01-15'),
    ('Sara Khan', 'sara@example.com', '0312-9876543', 'Flat 3, Gulshan, Karachi', '2024-02-20'),
    ('Ahmed Raza', 'ahmed@example.com', '0321-5551234', 'Street 5, DHA, Lahore', '2024-03-10'),
    ('Fatima Malik', 'fatima@example.com', '0333-7778888', 'House 7, F-8, Islamabad', '2024-04-05'),
    ('Usman Tariq', 'usman@example.com', '0345-2223333', 'Block C, Model Town, Lahore', '2024-05-01');

    CREATE VIEW IF NOT EXISTS view_books_with_category AS
    SELECT b.book_id, b.title, b.author, b.isbn, c.category_name,
           b.total_copies, b.available_copies, b.published_year, b.publisher
    FROM books b
    LEFT JOIN categories c ON b.category_id = c.category_id;

    CREATE VIEW IF NOT EXISTS view_active_issues AS
    SELECT i.issue_id, b.title, b.author, m.name AS member_name,
           m.email, i.issue_date, i.due_date,
           CASE WHEN i.due_date < CURRENT_DATE THEN 'OVERDUE' ELSE 'On Time' END AS status
    FROM issued_books i
    JOIN books b ON i.book_id = b.book_id
    JOIN members m ON i.member_id = m.member_id
    WHERE i.status = 'issued';

    CREATE VIEW IF NOT EXISTS view_overdue_books AS
    SELECT i.issue_id, b.title, m.name AS member_name, m.email, m.phone,
           i.due_date,
           CAST(julianday('now') - julianday(i.due_date) AS INTEGER) AS days_overdue,
           CAST(julianday('now') - julianday(i.due_date) AS INTEGER) * 10 AS fine_amount
    FROM issued_books i
    JOIN books b ON i.book_id = b.book_id
    JOIN members m ON i.member_id = m.member_id
    WHERE i.status = 'issued' AND i.due_date < CURRENT_DATE;

    CREATE VIEW IF NOT EXISTS view_member_history AS
    SELECT m.member_id, m.name, m.email, b.title, b.author,
           i.issue_date, i.due_date, i.return_date, i.status
    FROM issued_books i
    JOIN books b ON i.book_id = b.book_id
    JOIN members m ON i.member_id = m.member_id
    ORDER BY i.issue_date DESC;

    CREATE VIEW IF NOT EXISTS view_book_availability AS
    SELECT book_id, title, author, total_copies, available_copies,
           (total_copies - available_copies) AS issued_copies,
           CASE WHEN available_copies > 0 THEN 'Available' ELSE 'Not Available' END AS availability
    FROM books;

    CREATE VIEW IF NOT EXISTS view_unpaid_fines AS
    SELECT f.fine_id, m.name AS member_name, m.email, b.title,
           f.fine_amount, f.fine_date, f.paid
    FROM fines f
    JOIN issued_books i ON f.issue_id = i.issue_id
    JOIN members m ON f.member_id = m.member_id
    JOIN books b ON i.book_id = b.book_id
    WHERE f.paid = 0;

    CREATE VIEW IF NOT EXISTS view_books_per_category AS
    SELECT c.category_name, COUNT(b.book_id) AS total_books,
           SUM(b.available_copies) AS available_books
    FROM categories c
    LEFT JOIN books b ON c.category_id = b.category_id
    GROUP BY c.category_name;

    CREATE VIEW IF NOT EXISTS view_most_borrowed AS
    SELECT b.title, b.author, COUNT(i.issue_id) AS times_borrowed
    FROM books b
    LEFT JOIN issued_books i ON b.book_id = i.book_id
    GROUP BY b.book_id, b.title, b.author
    ORDER BY times_borrowed DESC;

    CREATE VIEW IF NOT EXISTS view_active_members AS
    SELECT m.member_id, m.name, m.email, m.phone,
           COUNT(i.issue_id) AS books_currently_issued
    FROM members m
    JOIN issued_books i ON m.member_id = i.member_id
    WHERE i.status = 'issued'
    GROUP BY m.member_id, m.name, m.email, m.phone;

    CREATE VIEW IF NOT EXISTS view_dashboard_stats AS
    SELECT
        (SELECT COUNT(*) FROM books) AS total_books,
        (SELECT COUNT(*) FROM members WHERE status = 'active') AS total_members,
        (SELECT COUNT(*) FROM issued_books WHERE status = 'issued') AS books_issued,
        (SELECT COUNT(*) FROM issued_books WHERE status = 'issued' AND due_date < CURRENT_DATE) AS overdue_books,
        (SELECT COALESCE(SUM(fine_amount), 0) FROM fines WHERE paid = 0) AS pending_fines;
SQL;

    $conn->exec($schema);
}
?>
