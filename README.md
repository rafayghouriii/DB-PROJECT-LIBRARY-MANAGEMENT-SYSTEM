# 📚 LibraRy — Modern Library Management System

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

Welcome to **LibraRy**, a highly polished, aesthetic, and fully functional Library Management System. Built with a sleek dark-mode UI and gold accents, this system offers a premium experience for managing library catalogs, circulation, and members.

---

## ✨ Features

### 📊 Interactive Dashboard
Get an instant overview of your library's health. The dashboard tracks:
- Total books and active members.
- Number of books currently issued.
- Overdue books and pending fine calculations.
- Quick views of **Active Issues** and the **Most Borrowed Books**.

### 📖 Complete Catalogue Management
- **Add, Edit, and Delete Books:** Manage titles, authors, ISBNs, publishers, and publication years.
- **Categorization:** Organize books into logical categories (Science Fiction, History, Programming, etc.) and track available copies per category.
- **Real-time Search:** Instantly find books using a dynamic search filter.

### 👥 Member Management
- Keep track of all library members.
- Store contact information, addresses, and membership status (Active/Inactive).
- Track borrowing history per member.

### 🔄 Book Circulation & Fine Tracking
- **Issue Books:** Seamlessly issue books to members. (Includes an adjustable issue date for testing overdue logic!).
- **Returns:** One-click return processing.
- **Overdue & Fines:** Automatically calculates overdue days (after a 14-day limit) and generates fines dynamically.

---

## 🎨 UI & Aesthetics

The application ditches boring, standard templates for a **bespoke, modern design**:
- **Color Palette:** Deep background `var(--bg: #0f0e0c)` contrasted with elegant gold accents `var(--gold: #c9a84c)`.
- **Typography:** Features beautiful pairings of **DM Serif Display** for headings and **DM Sans** for readable body text.
- **Micro-animations:** Smooth hover states, toast notifications, and modal transitions make the interface feel alive.

---

## 🚀 Quick Start & Installation

You can get this project up and running in a few minutes using a local server environment like **XAMPP**, **WAMP**, or **MAMP**.

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/librarymanagement.git
   ```
2. **Move to your server directory:**
   - For XAMPP: Move the folder to `C:\xampp\htdocs\librarymanagement`
   - For WAMP: Move the folder to `C:\wamp\www\librarymanagement`
3. **Start your server:**
   Ensure that **Apache** is running. (No separate database server like MySQL is needed, as it uses a portable SQLite database!)
4. **Open in Browser:**
   Navigate to `http://localhost/librarymanagement` in your web browser.

---

## 📂 Project Structure

```text
librarymanagement/
├── index.php         # Entry point, redirects to the main app
├── app.php           # Main Frontend Application (HTML/CSS/JS)
├── api.php           # Backend API handling requests
├── db.php            # Database connection logic (SQLite)
├── database.sqlite   # Portable SQLite Database file
└── database.sql      # Database schema and initial seed data
```

---

## 🛠️ Tech Stack

- **Frontend:** Pure HTML5, CSS3 (Vanilla), and JavaScript. No bulky frameworks.
- **Backend:** PHP 8+ handling API routing and logic.
- **Database:** SQLite3. Lightweight, zero-configuration database that lives right in the project folder.

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues page](https://github.com/yourusername/librarymanagement/issues) if you want to contribute.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

*Crafted with ❤️ for book lovers and administrators.*
