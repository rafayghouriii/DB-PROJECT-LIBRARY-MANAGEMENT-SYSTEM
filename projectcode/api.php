<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once 'db.php';

$db = getDB();
$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {

        // DASHBOARD 
        case 'dashboard_stats':
            // Query 10: Dashboard statistics
            $stmt = $db->query("SELECT * FROM view_dashboard_stats");
            echo json_encode($stmt->fetch());
            break;

        //  BOOKS 
        case 'get_books':
            // Query 1: All books with category
            $search = '%' . ($_GET['search'] ?? '') . '%';
            $stmt = $db->prepare("SELECT * FROM view_books_with_category WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ? ORDER BY title");
            $stmt->execute([$search, $search, $search]);
            echo json_encode($stmt->fetchAll());
            break;

        case 'get_book':
            // Query: Single book detail
            $stmt = $db->prepare("SELECT * FROM view_books_with_category WHERE book_id = ?");
            $stmt->execute([$_GET['id']]);
            echo json_encode($stmt->fetch());
            break;

        case 'add_book':
            // Query: Insert new book
            $d = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("INSERT INTO books (title, author, isbn, category_id, total_copies, available_copies, published_year, publisher) VALUES (?,?,?,?,?,?,?,?)");
            $copies = intval($d['total_copies'] ?? 1);
            $stmt->execute([$d['title'], $d['author'], $d['isbn'] ?? null, $d['category_id'] ?? null, $copies, $copies, $d['published_year'] ?? null, $d['publisher'] ?? null]);
            echo json_encode(['success' => true, 'id' => $db->lastInsertId()]);
            break;

        case 'edit_book':
            // Query: Update book
            $d = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("UPDATE books SET title=?, author=?, isbn=?, category_id=?, total_copies=?, published_year=?, publisher=? WHERE book_id=?");
            $stmt->execute([$d['title'], $d['author'], $d['isbn'] ?? null, $d['category_id'] ?? null, $d['total_copies'], $d['published_year'] ?? null, $d['publisher'] ?? null, $d['book_id']]);
            echo json_encode(['success' => true]);
            break;

        case 'delete_book':
            // Query: Delete book
            $d = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("DELETE FROM books WHERE book_id = ?");
            $stmt->execute([$d['id']]);
            echo json_encode(['success' => true]);
            break;

        case 'book_availability':
            // Query 5: Book availability view
            $stmt = $db->query("SELECT * FROM view_book_availability ORDER BY title");
            echo json_encode($stmt->fetchAll());
            break;

        case 'most_borrowed':
            // Query 8: Most borrowed books
            $stmt = $db->query("SELECT * FROM view_most_borrowed LIMIT 10");
            echo json_encode($stmt->fetchAll());
            break;

        // CATEGORIES 
        case 'get_categories':
            // Query: All categories
            $stmt = $db->query("SELECT * FROM categories ORDER BY category_name");
            echo json_encode($stmt->fetchAll());
            break;

        case 'books_per_category':
            // Query 7: Books per category
            $stmt = $db->query("SELECT * FROM view_books_per_category ORDER BY total_books DESC");
            echo json_encode($stmt->fetchAll());
            break;

        // MEMBERS
        case 'get_members':
            // Query: All members with optional search
            $search = '%' . ($_GET['search'] ?? '') . '%';
            $stmt = $db->prepare("SELECT * FROM members WHERE name LIKE ? OR email LIKE ? ORDER BY name");
            $stmt->execute([$search, $search]);
            echo json_encode($stmt->fetchAll());
            break;

        case 'add_member':
            // Query: Insert member
            $d = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("INSERT INTO members (name, email, phone, address) VALUES (?,?,?,?)");
            $stmt->execute([$d['name'], $d['email'], $d['phone'] ?? null, $d['address'] ?? null]);
            echo json_encode(['success' => true]);
            break;

        case 'edit_member':
            // Query: Update member
            $d = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("UPDATE members SET name=?, email=?, phone=?, address=?, status=? WHERE member_id=?");
            $stmt->execute([$d['name'], $d['email'], $d['phone'] ?? null, $d['address'] ?? null, $d['status'] ?? 'active', $d['member_id']]);
            echo json_encode(['success' => true]);
            break;

        case 'delete_member':
            // Query: Delete member
            $d = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("DELETE FROM members WHERE member_id = ?");
            $stmt->execute([$d['id']]);
            echo json_encode(['success' => true]);
            break;

        case 'active_members':
            // Query 9: Members with currently issued books
            $stmt = $db->query("SELECT * FROM view_active_members");
            echo json_encode($stmt->fetchAll());
            break;

        // ISSUE / RETURN 
        case 'issue_book':
            // Query: Issue a book
            $d = json_decode(file_get_contents('php://input'), true);

            // Check availability
            $check = $db->prepare("SELECT available_copies FROM books WHERE book_id = ?");
            $check->execute([$d['book_id']]);
            $book = $check->fetch();
            if (!$book || $book['available_copies'] < 1) {
                echo json_encode(['success' => false, 'error' => 'No copies available']);
                break;
            }

            // Parse issue date or default to today
            $issue_date = !empty($d['issue_date']) ? $d['issue_date'] : date('Y-m-d');

            // Insert issue record
            $stmt = $db->prepare("INSERT INTO issued_books (book_id, member_id, issue_date, due_date) VALUES (?, ?, ?, date(?, '+14 days'))");
            $stmt->execute([$d['book_id'], $d['member_id'], $issue_date, $issue_date]);

            // Decrease available copies
            $db->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE book_id = ?")->execute([$d['book_id']]);
            echo json_encode(['success' => true]);
            break;

        case 'return_book':
            // Query: Return a book
            $d = json_decode(file_get_contents('php://input'), true);

            $find = $db->prepare("SELECT * FROM issued_books WHERE issue_id = ? AND status = 'issued'");
            $find->execute([$d['issue_id']]);
            $issue = $find->fetch();
            if (!$issue) { echo json_encode(['success' => false, 'error' => 'Record not found']); break; }

            // Mark returned
            $db->prepare("UPDATE issued_books SET return_date = CURRENT_DATE, status = 'returned' WHERE issue_id = ?")->execute([$d['issue_id']]);

            // Restore available copy
            $db->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE book_id = ?")->execute([$issue['book_id']]);

            // Calculate and save fine if overdue
            $fine = 0;
            if (strtotime($issue['due_date']) < time()) {
                $days = (time() - strtotime($issue['due_date'])) / 86400;
                $fine = ceil($days) * 10; // PKR 10 per day
                $db->prepare("INSERT INTO fines (issue_id, member_id, fine_amount) VALUES (?,?,?)")->execute([$d['issue_id'], $issue['member_id'], $fine]);
            }
            echo json_encode(['success' => true, 'fine' => $fine]);
            break;

        case 'active_issues':
            // Query 2: All currently issued books
            $stmt = $db->query("SELECT * FROM view_active_issues ORDER BY due_date ASC");
            echo json_encode($stmt->fetchAll());
            break;

        case 'overdue_books':
            // Query 3: Overdue books
            $stmt = $db->query("SELECT * FROM view_overdue_books ORDER BY days_overdue DESC");
            echo json_encode($stmt->fetchAll());
            break;

        case 'member_history':
            // Query 4: Full issue history
            $stmt = $db->query("SELECT * FROM view_member_history LIMIT 100");
            echo json_encode($stmt->fetchAll());
            break;

        case 'member_books':
            // Query: Specific member's issued books
            $stmt = $db->prepare("SELECT b.title, b.author, i.issue_date, i.due_date, i.status FROM issued_books i JOIN books b ON i.book_id = b.book_id WHERE i.member_id = ? ORDER BY i.issue_date DESC");
            $stmt->execute([$_GET['id']]);
            echo json_encode($stmt->fetchAll());
            break;

        //  FINES 
        case 'get_fines':
            // Query 6: Unpaid fines
            $stmt = $db->query("SELECT * FROM view_unpaid_fines ORDER BY fine_date DESC");
            echo json_encode($stmt->fetchAll());
            break;

        case 'pay_fine':
            // Query: Mark fine as paid
            $d = json_decode(file_get_contents('php://input'), true);
            $db->prepare("UPDATE fines SET paid = TRUE WHERE fine_id = ?")->execute([$d['fine_id']]);
            echo json_encode(['success' => true]);
            break;

        case 'search_books_by_author':
            // Query: Search by author
            $author = '%' . ($_GET['author'] ?? '') . '%';
            $stmt = $db->prepare("SELECT * FROM view_books_with_category WHERE author LIKE ? ORDER BY title");
            $stmt->execute([$author]);
            echo json_encode($stmt->fetchAll());
            break;

        case 'books_issued_today':
            // Query: Books issued today
            $stmt = $db->query("SELECT b.title, m.name AS member_name, i.due_date FROM issued_books i JOIN books b ON i.book_id = b.book_id JOIN members m ON i.member_id = m.member_id WHERE i.issue_date = CURRENT_DATE");
            echo json_encode($stmt->fetchAll());
            break;

        default:
            echo json_encode(['error' => 'Unknown action']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
