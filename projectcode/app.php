<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LibraRy — Library Management System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #0f0e0c;
  --surface: #1a1916;
  --surface2: #242220;
  --border: #2e2c29;
  --gold: #c9a84c;
  --gold-light: #e8c97a;
  --gold-dim: rgba(201,168,76,0.12);
  --text: #f0ede6;
  --text-muted: #857f73;
  --text-dim: #5a5650;
  --green: #4caf7d;
  --red: #e05c5c;
  --blue: #5b9bd5;
  --radius: 10px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { font-size: 15px; }
body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  display: flex;
}

/* ── SIDEBAR ─ */
.sidebar {
  width: 230px;
  min-height: 100vh;
  background: var(--surface);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
}
.logo {
  padding: 28px 22px 20px;
  border-bottom: 1px solid var(--border);
}
.logo-title {
  font-family: 'DM Serif Display', serif;
  font-size: 1.5rem;
  color: var(--gold);
  letter-spacing: 0.02em;
}
.logo-sub {
  font-size: 0.72rem;
  color: var(--text-dim);
  text-transform: uppercase;
  letter-spacing: 0.12em;
  margin-top: 2px;
}
.nav { flex: 1; padding: 14px 10px; }
.nav-section {
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: var(--text-dim);
  padding: 14px 12px 6px;
}
.nav-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 12px;
  border-radius: 7px;
  cursor: pointer;
  color: var(--text-muted);
  font-size: 0.88rem;
  font-weight: 400;
  transition: all 0.15s;
  margin-bottom: 2px;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
}
.nav-item:hover { background: var(--surface2); color: var(--text); }
.nav-item.active { background: var(--gold-dim); color: var(--gold); font-weight: 500; }
.nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }

/* ── MAIN ─*/
.main {
  margin-left: 230px;
  flex: 1;
  min-height: 100vh;
}
.topbar {
  height: 58px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 28px;
  background: var(--bg);
  position: sticky;
  top: 0;
  z-index: 50;
}
.page-title {
  font-size: 1.1rem;
  font-weight: 500;
}
.content { padding: 28px; }

/* ── CARDS ─ */
.stat-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 16px;
  margin-bottom: 28px;
}
.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 20px;
}
.stat-label {
  font-size: 0.72rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--text-dim);
  margin-bottom: 8px;
}
.stat-val {
  font-family: 'DM Serif Display', serif;
  font-size: 2rem;
  color: var(--gold);
  line-height: 1;
}
.stat-icon {
  margin-bottom: 12px;
  color: var(--text-dim);
}

/* ── TABLE ─ */
.table-wrap {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
}
.table-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  gap: 12px;
  flex-wrap: wrap;
}
.table-title {
  font-family: 'DM Serif Display', serif;
  font-size: 1.1rem;
}
.search-input {
  background: var(--surface2);
  border: 1px solid var(--border);
  border-radius: 7px;
  color: var(--text);
  padding: 7px 14px;
  font-family: inherit;
  font-size: 0.85rem;
  width: 220px;
  outline: none;
  transition: border-color 0.15s;
}
.search-input:focus { border-color: var(--gold); }
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.87rem;
}
thead th {
  text-align: left;
  padding: 11px 20px;
  font-size: 0.68rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--text-dim);
  border-bottom: 1px solid var(--border);
  font-weight: 500;
}
tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background 0.1s;
}
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: var(--surface2); }
td { padding: 12px 20px; color: var(--text-muted); vertical-align: middle; }
td:first-child { color: var(--text); }

/* ── BADGES ── */
.badge {
  display: inline-block;
  padding: 3px 9px;
  border-radius: 20px;
  font-size: 0.72rem;
  font-weight: 500;
}
.badge-green { background: rgba(76,175,125,0.12); color: var(--green); }
.badge-red { background: rgba(224,92,92,0.12); color: var(--red); }
.badge-gold { background: var(--gold-dim); color: var(--gold); }
.badge-blue { background: rgba(91,155,213,0.12); color: var(--blue); }

/* ── BUTTONS ─ */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 7px;
  font-family: inherit;
  font-size: 0.85rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s;
  border: none;
}
.btn-gold { background: var(--gold); color: #0f0e0c; }
.btn-gold:hover { background: var(--gold-light); }
.btn-ghost { background: var(--surface2); color: var(--text-muted); border: 1px solid var(--border); }
.btn-ghost:hover { color: var(--text); border-color: var(--text-dim); }
.btn-danger { background: rgba(224,92,92,0.1); color: var(--red); border: 1px solid rgba(224,92,92,0.2); }
.btn-danger:hover { background: rgba(224,92,92,0.2); }
.btn-sm { padding: 5px 11px; font-size: 0.8rem; }

/* ── MODAL ── */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  z-index: 1000;
  align-items: center;
  justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 12px;
  width: 480px;
  max-width: 95vw;
  max-height: 90vh;
  overflow-y: auto;
}
.modal-head {
  padding: 20px 24px 16px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-title { font-family: 'DM Serif Display', serif; font-size: 1.1rem; }
.modal-close {
  background: none;
  border: none;
  color: var(--text-dim);
  cursor: pointer;
  font-size: 1.3rem;
  line-height: 1;
  padding: 2px 6px;
}
.modal-close:hover { color: var(--text); }
.modal-body { padding: 20px 24px; }
.form-group { margin-bottom: 16px; }
label { display: block; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
input, select, textarea {
  width: 100%;
  background: var(--surface2);
  border: 1px solid var(--border);
  border-radius: 7px;
  color: var(--text);
  padding: 9px 14px;
  font-family: inherit;
  font-size: 0.88rem;
  outline: none;
  transition: border-color 0.15s;
}
input:focus, select:focus, textarea:focus { border-color: var(--gold); }
select option { background: var(--surface2); }
.modal-foot {
  padding: 16px 24px;
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

/* ── TOAST ── */
#toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 12px 20px;
  font-size: 0.88rem;
  color: var(--text);
  z-index: 9999;
  transform: translateY(80px);
  opacity: 0;
  transition: all 0.25s;
  max-width: 320px;
}
#toast.show { transform: translateY(0); opacity: 1; }
#toast.success { border-left: 3px solid var(--green); }
#toast.error { border-left: 3px solid var(--red); }

/* ── PAGE SECTIONS ────────── */
.page { display: none; }
.page.active { display: block; }

.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }

.empty {
  text-align: center;
  padding: 40px;
  color: var(--text-dim);
  font-size: 0.9rem;
}

.overdue-row td { color: var(--red) !important; }
.overdue-row td:first-child { color: var(--red) !important; }

.section-title {
  font-family: 'DM Serif Display', serif;
  font-size: 1.4rem;
  margin-bottom: 6px;
}
.section-sub {
  color: var(--text-muted);
  font-size: 0.85rem;
  margin-bottom: 22px;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="logo">
    <div class="logo-title">📚 LibraRy</div>
    <div class="logo-sub">Management System</div>
  </div>
  <nav class="nav">
    <div class="nav-section">Overview</div>
    <button class="nav-item active" onclick="showPage('dashboard', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </button>

    <div class="nav-section">Catalogue</div>
    <button class="nav-item" onclick="showPage('books', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      Books
    </button>
    <button class="nav-item" onclick="showPage('categories', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      Categories
    </button>

    <div class="nav-section">Members</div>
    <button class="nav-item" onclick="showPage('members', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Members
    </button>

    <div class="nav-section">Circulation</div>
    <button class="nav-item" onclick="showPage('issue', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
      Issue Book
    </button>
    <button class="nav-item" onclick="showPage('returns', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>
      Returns
    </button>
    <button class="nav-item" onclick="showPage('overdue', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Overdue
    </button>
    <button class="nav-item" onclick="showPage('fines', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
      Fines
    </button>

    <div class="nav-section">Reports</div>
    <button class="nav-item" onclick="showPage('reports', this)">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      Reports
    </button>
  </nav>
</aside>

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <span class="page-title" id="pageTitle">Dashboard</span>
    <div id="topbarAction"></div>
  </div>
  <div class="content">

    <!-- DASHBOARD -->
    <div class="page active" id="page-dashboard">
      <div class="section-title">Welcome back</div>
      <div class="section-sub">Here's what's happening in your library today.</div>
      <div class="stat-grid" id="statGrid">
        <div class="stat-card"><div class="stat-label">Total Books</div><div class="stat-val" id="s-books">—</div></div>
        <div class="stat-card"><div class="stat-label">Members</div><div class="stat-val" id="s-members">—</div></div>
        <div class="stat-card"><div class="stat-label">Books Issued</div><div class="stat-val" id="s-issued">—</div></div>
        <div class="stat-card"><div class="stat-label">Overdue</div><div class="stat-val" id="s-overdue" style="color:var(--red)">—</div></div>
        <div class="stat-card"><div class="stat-label">Pending Fines</div><div class="stat-val" id="s-fines" style="color:var(--gold)">—</div></div>
      </div>

      <div class="two-col">
        <div class="table-wrap">
          <div class="table-header"><span class="table-title">Active Issues</span></div>
          <table><thead><tr><th>Book</th><th>Member</th><th>Due Date</th><th>Status</th></tr></thead>
          <tbody id="dash-issues"><tr><td colspan="4" class="empty">Loading...</td></tr></tbody></table>
        </div>
        <div class="table-wrap">
          <div class="table-header"><span class="table-title">Most Borrowed</span></div>
          <table><thead><tr><th>Book</th><th>Author</th><th>Times</th></tr></thead>
          <tbody id="dash-popular"><tr><td colspan="3" class="empty">Loading...</td></tr></tbody></table>
        </div>
      </div>
    </div>

    <!-- BOOKS -->
    <div class="page" id="page-books">
      <div class="table-wrap">
        <div class="table-header">
          <span class="table-title">All Books</span>
          <div style="display:flex;gap:10px;align-items:center">
            <input class="search-input" placeholder="Search title, author, ISBN…" id="bookSearch" oninput="loadBooks()">
            <button class="btn btn-gold" onclick="openModal('addBookModal')">+ Add Book</button>
          </div>
        </div>
        <table>
          <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Available</th><th>Year</th><th>Actions</th></tr></thead>
          <tbody id="booksTable"><tr><td colspan="6" class="empty">Loading...</td></tr></tbody>
        </table>
      </div>
    </div>

    <!-- CATEGORIES -->
    <div class="page" id="page-categories">
      <div class="table-wrap">
        <div class="table-header"><span class="table-title">Books Per Category</span></div>
        <table>
          <thead><tr><th>Category</th><th>Total Books</th><th>Available Copies</th></tr></thead>
          <tbody id="catTable"><tr><td colspan="3" class="empty">Loading...</td></tr></tbody>
        </table>
      </div>
    </div>

    <!-- MEMBERS -->
    <div class="page" id="page-members">
      <div class="table-wrap">
        <div class="table-header">
          <span class="table-title">Members</span>
          <div style="display:flex;gap:10px">
            <input class="search-input" placeholder="Search name or email…" id="memberSearch" oninput="loadMembers()">
            <button class="btn btn-gold" onclick="openModal('addMemberModal')">+ Add Member</button>
          </div>
        </div>
        <table>
          <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody id="membersTable"><tr><td colspan="6" class="empty">Loading...</td></tr></tbody>
        </table>
      </div>
    </div>

    <!-- ISSUE BOOK -->
    <div class="page" id="page-issue">
      <div style="max-width:500px">
        <div class="section-title">Issue a Book</div>
        <div class="section-sub">Select a member and book to issue. Due date is set 14 days from issue date.</div>
        <div class="table-wrap" style="padding:24px">
          <div class="form-group">
            <label>Member</label>
            <select id="issueMember"></select>
          </div>
          <div class="form-group">
            <label>Book</label>
            <select id="issueBook"></select>
          </div>
          <div class="form-group">
            <label>Issue Date (For demo/backdating)</label>
            <input type="date" id="issueDate">
          </div>
          <button class="btn btn-gold" style="width:100%;justify-content:center" onclick="issueBook()">Issue Book →</button>
        </div>
      </div>
    </div>

    <!-- RETURNS -->
    <div class="page" id="page-returns">
      <div class="table-wrap">
        <div class="table-header"><span class="table-title">Currently Issued — Select to Return</span></div>
        <table>
          <thead><tr><th>Book</th><th>Member</th><th>Issue Date</th><th>Due Date</th><th>Status</th><th>Action</th></tr></thead>
          <tbody id="returnsTable"><tr><td colspan="6" class="empty">Loading...</td></tr></tbody>
        </table>
      </div>
    </div>

    <!-- OVERDUE -->
    <div class="page" id="page-overdue">
      <div class="table-wrap">
        <div class="table-header"><span class="table-title">Overdue Books</span></div>
        <table>
          <thead><tr><th>Book</th><th>Member</th><th>Phone</th><th>Due Date</th><th>Days Overdue</th><th>Fine (PKR)</th></tr></thead>
          <tbody id="overdueTable"><tr><td colspan="6" class="empty">Loading...</td></tr></tbody>
        </table>
      </div>
    </div>

    <!-- FINES -->
    <div class="page" id="page-fines">
      <div class="table-wrap">
        <div class="table-header"><span class="table-title">Unpaid Fines</span></div>
        <table>
          <thead><tr><th>Member</th><th>Book</th><th>Amount (PKR)</th><th>Date</th><th>Action</th></tr></thead>
          <tbody id="finesTable"><tr><td colspan="5" class="empty">Loading...</td></tr></tbody>
        </table>
      </div>
    </div>

    <!-- REPORTS -->
    <div class="page" id="page-reports">
      <div class="section-title">Reports</div>
      <div class="section-sub">Full borrowing history and availability overview.</div>
      <div style="margin-bottom:20px">
        <button class="btn btn-ghost" onclick="loadReport('history')" style="margin-right:8px">Borrowing History</button>
        <button class="btn btn-ghost" onclick="loadReport('availability')">Book Availability</button>
      </div>
      <div class="table-wrap" id="reportWrap" style="display:none"></div>
    </div>

  </div>
</main>

<!-- ── MODALS ─-->

<!-- Add Book -->
<div class="modal-overlay" id="addBookModal">
  <div class="modal">
    <div class="modal-head"><span class="modal-title">Add New Book</span><button class="modal-close" onclick="closeModal('addBookModal')">×</button></div>
    <div class="modal-body">
      <div class="form-group"><label>Title *</label><input id="nb-title" placeholder="Book title"></div>
      <div class="form-group"><label>Author *</label><input id="nb-author" placeholder="Author name"></div>
      <div class="form-group"><label>ISBN</label><input id="nb-isbn" placeholder="ISBN number"></div>
      <div class="form-group"><label>Category</label><select id="nb-cat"></select></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <div class="form-group"><label>Copies</label><input id="nb-copies" type="number" value="1" min="1"></div>
        <div class="form-group"><label>Year</label><input id="nb-year" type="number" placeholder="e.g. 2020"></div>
      </div>
      <div class="form-group"><label>Publisher</label><input id="nb-pub" placeholder="Publisher name"></div>
    </div>
    <div class="modal-foot">
      <button class="btn btn-ghost" onclick="closeModal('addBookModal')">Cancel</button>
      <button class="btn btn-gold" onclick="addBook()">Add Book</button>
    </div>
  </div>
</div>

<!-- Edit Book -->
<div class="modal-overlay" id="editBookModal">
  <div class="modal">
    <div class="modal-head"><span class="modal-title">Edit Book</span><button class="modal-close" onclick="closeModal('editBookModal')">×</button></div>
    <div class="modal-body">
      <input type="hidden" id="eb-id">
      <div class="form-group"><label>Title *</label><input id="eb-title"></div>
      <div class="form-group"><label>Author *</label><input id="eb-author"></div>
      <div class="form-group"><label>ISBN</label><input id="eb-isbn"></div>
      <div class="form-group"><label>Category</label><select id="eb-cat"></select></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <div class="form-group"><label>Total Copies</label><input id="eb-copies" type="number" min="1"></div>
        <div class="form-group"><label>Year</label><input id="eb-year" type="number"></div>
      </div>
      <div class="form-group"><label>Publisher</label><input id="eb-pub"></div>
    </div>
    <div class="modal-foot">
      <button class="btn btn-ghost" onclick="closeModal('editBookModal')">Cancel</button>
      <button class="btn btn-gold" onclick="saveBook()">Save Changes</button>
    </div>
  </div>
</div>

<!-- Add Member -->
<div class="modal-overlay" id="addMemberModal">
  <div class="modal">
    <div class="modal-head"><span class="modal-title">Add New Member</span><button class="modal-close" onclick="closeModal('addMemberModal')">×</button></div>
    <div class="modal-body">
      <div class="form-group"><label>Full Name *</label><input id="nm-name" placeholder="Member's full name"></div>
      <div class="form-group"><label>Email *</label><input id="nm-email" type="email" placeholder="email@example.com"></div>
      <div class="form-group"><label>Phone</label><input id="nm-phone" placeholder="0300-1234567"></div>
      <div class="form-group"><label>Address</label><textarea id="nm-addr" rows="2" placeholder="Home address"></textarea></div>
    </div>
    <div class="modal-foot">
      <button class="btn btn-ghost" onclick="closeModal('addMemberModal')">Cancel</button>
      <button class="btn btn-gold" onclick="addMember()">Add Member</button>
    </div>
  </div>
</div>

<!-- Edit Member -->
<div class="modal-overlay" id="editMemberModal">
  <div class="modal">
    <div class="modal-head"><span class="modal-title">Edit Member</span><button class="modal-close" onclick="closeModal('editMemberModal')">×</button></div>
    <div class="modal-body">
      <input type="hidden" id="em-id">
      <div class="form-group"><label>Full Name *</label><input id="em-name"></div>
      <div class="form-group"><label>Email *</label><input id="em-email" type="email"></div>
      <div class="form-group"><label>Phone</label><input id="em-phone"></div>
      <div class="form-group"><label>Address</label><textarea id="em-addr" rows="2"></textarea></div>
      <div class="form-group"><label>Status</label><select id="em-status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
    </div>
    <div class="modal-foot">
      <button class="btn btn-ghost" onclick="closeModal('editMemberModal')">Cancel</button>
      <button class="btn btn-gold" onclick="saveMember()">Save Changes</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast"></div>

<script>
const API = 'api.php';

// ── UTILS ───
function api(action, method='GET', body=null) {
  const url = method === 'GET' ? `${API}?action=${action}` : API + '?action=' + action;
  return fetch(url, {
    method,
    headers: method !== 'GET' ? {'Content-Type':'application/json'} : {},
    body: body ? JSON.stringify({action,...body}) : null
  }).then(r => r.json());
}

function toast(msg, type='success') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'show ' + type;
  setTimeout(() => t.className = '', 3000);
}

function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function showPage(name, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + name).classList.add('active');
  el.classList.add('active');
  const titles = {dashboard:'Dashboard',books:'Books',categories:'Categories',members:'Members',issue:'Issue Book',returns:'Returns',overdue:'Overdue Books',fines:'Fines',reports:'Reports'};
  document.getElementById('pageTitle').textContent = titles[name] || name;
  loadPage(name);
}

function loadPage(name) {
  if (name === 'dashboard') loadDashboard();
  if (name === 'books') loadBooks();
  if (name === 'categories') loadCategories();
  if (name === 'members') loadMembers();
  if (name === 'issue') loadIssueForm();
  if (name === 'returns') loadReturns();
  if (name === 'overdue') loadOverdue();
  if (name === 'fines') loadFines();
}

// ── DASHBOARD
async function loadDashboard() {
  const s = await fetch(`${API}?action=dashboard_stats`).then(r=>r.json());
  document.getElementById('s-books').textContent = s.total_books ?? 0;
  document.getElementById('s-members').textContent = s.total_members ?? 0;
  document.getElementById('s-issued').textContent = s.books_issued ?? 0;
  document.getElementById('s-overdue').textContent = s.overdue_books ?? 0;
  document.getElementById('s-fines').textContent = 'PKR ' + (s.pending_fines ?? 0);

  const issues = await fetch(`${API}?action=active_issues`).then(r=>r.json());
  const ib = document.getElementById('dash-issues');
  if (!issues.length) { ib.innerHTML = '<tr><td colspan="4" class="empty">No active issues</td></tr>'; }
  else ib.innerHTML = issues.slice(0,6).map(i => `
    <tr>
      <td>${i.title}</td>
      <td>${i.member_name}</td>
      <td>${i.due_date}</td>
      <td><span class="badge ${i.status==='OVERDUE'?'badge-red':'badge-green'}">${i.status}</span></td>
    </tr>`).join('');

  const pop = await fetch(`${API}?action=most_borrowed`).then(r=>r.json());
  const pb = document.getElementById('dash-popular');
  if (!pop.length) { pb.innerHTML = '<tr><td colspan="3" class="empty">No data</td></tr>'; }
  else pb.innerHTML = pop.slice(0,6).map(b => `
    <tr><td>${b.title}</td><td>${b.author}</td><td><span class="badge badge-gold">${b.times_borrowed}</span></td></tr>`).join('');
}

// BOOKS 
async function loadBooks() {
  const q = document.getElementById('bookSearch')?.value || '';
  const books = await fetch(`${API}?action=get_books&search=${encodeURIComponent(q)}`).then(r=>r.json());
  const tb = document.getElementById('booksTable');
  if (!books.length) { tb.innerHTML = '<tr><td colspan="6" class="empty">No books found</td></tr>'; return; }
  tb.innerHTML = books.map(b => `
    <tr>
      <td>${b.title}</td>
      <td>${b.author}</td>
      <td><span class="badge badge-blue">${b.category_name || 'Uncategorized'}</span></td>
      <td><span class="badge ${b.available_copies > 0 ? 'badge-green':'badge-red'}">${b.available_copies}/${b.total_copies}</span></td>
      <td>${b.published_year || '—'}</td>
      <td>
        <button class="btn btn-ghost btn-sm" onclick="editBookOpen(${JSON.stringify(b).replace(/"/g,'&quot;')})">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteBook(${b.book_id})">Del</button>
      </td>
    </tr>`).join('');
}

async function loadCatOptions(selId, selectedVal) {
  const cats = await fetch(`${API}?action=get_categories`).then(r=>r.json());
  const el = document.getElementById(selId);
  el.innerHTML = '<option value="">-- Select Category --</option>' + cats.map(c=>`<option value="${c.category_id}" ${c.category_id==selectedVal?'selected':''}>${c.category_name}</option>`).join('');
}

async function addBook() {
  const d = { title: document.getElementById('nb-title').value.trim(), author: document.getElementById('nb-author').value.trim(), isbn: document.getElementById('nb-isbn').value.trim(), category_id: document.getElementById('nb-cat').value, total_copies: document.getElementById('nb-copies').value, published_year: document.getElementById('nb-year').value, publisher: document.getElementById('nb-pub').value.trim() };
  if (!d.title || !d.author) { toast('Title and author are required', 'error'); return; }
  const r = await api('add_book', 'POST', d);
  if (r.success) { closeModal('addBookModal'); loadBooks(); toast('Book added successfully'); }
  else toast(r.error || 'Failed to add book', 'error');
}

function editBookOpen(b) {
  document.getElementById('eb-id').value = b.book_id;
  document.getElementById('eb-title').value = b.title;
  document.getElementById('eb-author').value = b.author;
  document.getElementById('eb-isbn').value = b.isbn || '';
  document.getElementById('eb-copies').value = b.total_copies;
  document.getElementById('eb-year').value = b.published_year || '';
  document.getElementById('eb-pub').value = b.publisher || '';
  loadCatOptions('eb-cat', b.category_id);
  openModal('editBookModal');
}

async function saveBook() {
  const d = { book_id: document.getElementById('eb-id').value, title: document.getElementById('eb-title').value.trim(), author: document.getElementById('eb-author').value.trim(), isbn: document.getElementById('eb-isbn').value.trim(), category_id: document.getElementById('eb-cat').value, total_copies: document.getElementById('eb-copies').value, published_year: document.getElementById('eb-year').value, publisher: document.getElementById('eb-pub').value.trim() };
  const r = await api('edit_book', 'POST', d);
  if (r.success) { closeModal('editBookModal'); loadBooks(); toast('Book updated'); }
  else toast(r.error || 'Failed to update', 'error');
}

async function deleteBook(id) {
  if (!confirm('Delete this book?')) return;
  const r = await api('delete_book', 'POST', {id});
  if (r.success) { loadBooks(); toast('Book deleted'); }
  else toast(r.error || 'Cannot delete — may have issue records', 'error');
}

// CATEGORIES
async function loadCategories() {
  const cats = await fetch(`${API}?action=books_per_category`).then(r=>r.json());
  const tb = document.getElementById('catTable');
  if (!cats.length) { tb.innerHTML = '<tr><td colspan="3" class="empty">No categories</td></tr>'; return; }
  tb.innerHTML = cats.map(c => `
    <tr>
      <td>${c.category_name}</td>
      <td><span class="badge badge-gold">${c.total_books}</span></td>
      <td>${c.available_books ?? 0}</td>
    </tr>`).join('');
}

//  MEMBERS 
async function loadMembers() {
  const q = document.getElementById('memberSearch')?.value || '';
  const members = await fetch(`${API}?action=get_members&search=${encodeURIComponent(q)}`).then(r=>r.json());
  const tb = document.getElementById('membersTable');
  if (!members.length) { tb.innerHTML = '<tr><td colspan="6" class="empty">No members found</td></tr>'; return; }
  tb.innerHTML = members.map(m => `
    <tr>
      <td>${m.name}</td>
      <td>${m.email}</td>
      <td>${m.phone || '—'}</td>
      <td>${m.membership_date}</td>
      <td><span class="badge ${m.status==='active'?'badge-green':'badge-red'}">${m.status}</span></td>
      <td>
        <button class="btn btn-ghost btn-sm" onclick="editMemberOpen(${JSON.stringify(m).replace(/"/g,'&quot;')})">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteMember(${m.member_id})">Del</button>
      </td>
    </tr>`).join('');
}

async function addMember() {
  const d = { name: document.getElementById('nm-name').value.trim(), email: document.getElementById('nm-email').value.trim(), phone: document.getElementById('nm-phone').value.trim(), address: document.getElementById('nm-addr').value.trim() };
  if (!d.name || !d.email) { toast('Name and email required', 'error'); return; }
  const r = await api('add_member', 'POST', d);
  if (r.success) { closeModal('addMemberModal'); loadMembers(); toast('Member added'); }
  else toast(r.error || 'Failed', 'error');
}

function editMemberOpen(m) {
  document.getElementById('em-id').value = m.member_id;
  document.getElementById('em-name').value = m.name;
  document.getElementById('em-email').value = m.email;
  document.getElementById('em-phone').value = m.phone || '';
  document.getElementById('em-addr').value = m.address || '';
  document.getElementById('em-status').value = m.status;
  openModal('editMemberModal');
}

async function saveMember() {
  const d = { member_id: document.getElementById('em-id').value, name: document.getElementById('em-name').value.trim(), email: document.getElementById('em-email').value.trim(), phone: document.getElementById('em-phone').value.trim(), address: document.getElementById('em-addr').value.trim(), status: document.getElementById('em-status').value };
  const r = await api('edit_member', 'POST', d);
  if (r.success) { closeModal('editMemberModal'); loadMembers(); toast('Member updated'); }
  else toast(r.error || 'Failed', 'error');
}

async function deleteMember(id) {
  if (!confirm('Delete this member?')) return;
  const r = await api('delete_member', 'POST', {id});
  if (r.success) { loadMembers(); toast('Member deleted'); }
  else toast(r.error || 'Cannot delete — has issue records', 'error');
}

// ISSUE BOOK 
async function loadIssueForm() {
  const [members, books] = await Promise.all([
    fetch(`${API}?action=get_members`).then(r=>r.json()),
    fetch(`${API}?action=book_availability`).then(r=>r.json())
  ]);
  document.getElementById('issueMember').innerHTML = members.map(m=>`<option value="${m.member_id}">${m.name} (${m.email})</option>`).join('');
  document.getElementById('issueBook').innerHTML = books.filter(b=>b.available_copies>0).map(b=>`<option value="${b.book_id}">${b.title} — ${b.author} [${b.available_copies} left]</option>`).join('');
  document.getElementById('issueDate').value = new Date().toISOString().split('T')[0];
}

async function issueBook() {
  const d = { book_id: document.getElementById('issueBook').value, member_id: document.getElementById('issueMember').value, issue_date: document.getElementById('issueDate').value };
  if (!d.book_id || !d.member_id) { toast('Select both member and book', 'error'); return; }
  const r = await api('issue_book', 'POST', d);
  if (r.success) { loadIssueForm(); toast('Book issued! Due in 14 days.'); }
  else toast(r.error || 'Failed to issue', 'error');
}

//  RETURNS 
async function loadReturns() {
  const issues = await fetch(`${API}?action=active_issues`).then(r=>r.json());
  const tb = document.getElementById('returnsTable');
  if (!issues.length) { tb.innerHTML = '<tr><td colspan="6" class="empty">No books currently issued</td></tr>'; return; }
  tb.innerHTML = issues.map(i => `
    <tr class="${i.status==='OVERDUE'?'overdue-row':''}">
      <td>${i.title}</td>
      <td>${i.member_name}</td>
      <td>${i.issue_date}</td>
      <td>${i.due_date}</td>
      <td><span class="badge ${i.status==='OVERDUE'?'badge-red':'badge-green'}">${i.status}</span></td>
      <td><button class="btn btn-gold btn-sm" onclick="returnBook(${i.issue_id})">Return</button></td>
    </tr>`).join('');
}

async function returnBook(issue_id) {
  if (!confirm('Mark this book as returned?')) return;
  const r = await api('return_book', 'POST', {issue_id});
  if (r.success) {
    loadReturns();
    if (r.fine > 0) toast(`Returned! Fine added: PKR ${r.fine}`, 'error');
    else toast('Book returned successfully!');
  } else toast(r.error || 'Failed', 'error');
}

//  OVERDUE
async function loadOverdue() {
  const rows = await fetch(`${API}?action=overdue_books`).then(r=>r.json());
  const tb = document.getElementById('overdueTable');
  if (!rows.length) { tb.innerHTML = '<tr><td colspan="6" class="empty" style="color:var(--green)">✓ No overdue books</td></tr>'; return; }
  tb.innerHTML = rows.map(r => `
    <tr class="overdue-row">
      <td>${r.title}</td>
      <td>${r.member_name}</td>
      <td>${r.phone || '—'}</td>
      <td>${r.due_date}</td>
      <td>${r.days_overdue} days</td>
      <td>PKR ${r.fine_amount}</td>
    </tr>`).join('');
}

// FINES
async function loadFines() {
  const fines = await fetch(`${API}?action=get_fines`).then(r=>r.json());
  const tb = document.getElementById('finesTable');
  if (!fines.length) { tb.innerHTML = '<tr><td colspan="5" class="empty" style="color:var(--green)">✓ No pending fines</td></tr>'; return; }
  tb.innerHTML = fines.map(f => `
    <tr>
      <td>${f.member_name}</td>
      <td>${f.title}</td>
      <td style="color:var(--red)">PKR ${f.fine_amount}</td>
      <td>${f.fine_date}</td>
      <td><button class="btn btn-gold btn-sm" onclick="payFine(${f.fine_id})">Mark Paid</button></td>
    </tr>`).join('');
}

async function payFine(fine_id) {
  const r = await api('pay_fine', 'POST', {fine_id});
  if (r.success) { loadFines(); toast('Fine marked as paid'); }
  else toast('Failed', 'error');
}

// REPORTS
async function loadReport(type) {
  const wrap = document.getElementById('reportWrap');
  wrap.style.display = 'block';
  wrap.innerHTML = '<div class="empty">Loading...</div>';

  if (type === 'history') {
    const rows = await fetch(`${API}?action=member_history`).then(r=>r.json());
    wrap.innerHTML = `
      <div class="table-header"><span class="table-title">Full Borrowing History</span></div>
      <table>
        <thead><tr><th>Member</th><th>Book</th><th>Author</th><th>Issue Date</th><th>Due Date</th><th>Return Date</th><th>Status</th></tr></thead>
        <tbody>${rows.length ? rows.map(r=>`
          <tr>
            <td>${r.name}</td><td>${r.title}</td><td>${r.author}</td>
            <td>${r.issue_date}</td><td>${r.due_date}</td>
            <td>${r.return_date || '—'}</td>
            <td><span class="badge ${r.status==='returned'?'badge-green':'badge-gold'}">${r.status}</span></td>
          </tr>`).join('') : '<tr><td colspan="7" class="empty">No history</td></tr>'}
        </tbody>
      </table>`;
  }

  if (type === 'availability') {
    const rows = await fetch(`${API}?action=book_availability`).then(r=>r.json());
    wrap.innerHTML = `
      <div class="table-header"><span class="table-title">Book Availability</span></div>
      <table>
        <thead><tr><th>Title</th><th>Author</th><th>Total</th><th>Issued</th><th>Available</th><th>Status</th></tr></thead>
        <tbody>${rows.map(b=>`
          <tr>
            <td>${b.title}</td><td>${b.author}</td>
            <td>${b.total_copies}</td><td>${b.issued_copies}</td><td>${b.available_copies}</td>
            <td><span class="badge ${b.availability==='Available'?'badge-green':'badge-red'}">${b.availability}</span></td>
          </tr>`).join('')}
        </tbody>
      </table>`;
  }
}

// INIT
loadCatOptions('nb-cat', null);
loadDashboard();

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
});
</script>
</body>
</html>
